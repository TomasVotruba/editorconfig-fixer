<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\Command;

use EditorconfigFixer202309\Symfony\Component\Console\Command\Command;
use EditorconfigFixer202309\Symfony\Component\Console\Helper\ProgressBar;
use EditorconfigFixer202309\Symfony\Component\Console\Input\InputArgument;
use EditorconfigFixer202309\Symfony\Component\Console\Input\InputInterface;
use EditorconfigFixer202309\Symfony\Component\Console\Input\InputOption;
use EditorconfigFixer202309\Symfony\Component\Console\Output\OutputInterface;
use EditorconfigFixer202309\Symfony\Component\Console\Style\SymfonyStyle;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\EditorConfig\EditorConfigFactory;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\EditorConfig\IndentionFixer;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\Exception\ShouldNotHappenException;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\FilePathHelper;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\Finder\PhpFilesFinder;
use EditorconfigFixer202309\Webmozart\Assert\Assert;
final class FixCommand extends Command
{
    /**
     * @readonly
     * @var \TomasVotruba\EditorconfigFixer\Finder\PhpFilesFinder
     */
    private $phpFilesFinder;
    /**
     * @readonly
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @readonly
     * @var \TomasVotruba\EditorconfigFixer\EditorConfig\IndentionFixer
     */
    private $indentionFixer;
    /**
     * @readonly
     * @var \TomasVotruba\EditorconfigFixer\EditorConfig\EditorConfigFactory
     */
    private $editorConfigFactory;
    /**
     * @var string
     * @see https://regex101.com/r/OhyrZy/1
     */
    private const FILE_SUFFIX_PATTERN = '#^[a-z]{3,4}$#';
    public function __construct(PhpFilesFinder $phpFilesFinder, SymfonyStyle $symfonyStyle, IndentionFixer $indentionFixer, EditorConfigFactory $editorConfigFactory)
    {
        $this->phpFilesFinder = $phpFilesFinder;
        $this->symfonyStyle = $symfonyStyle;
        $this->indentionFixer = $indentionFixer;
        $this->editorConfigFactory = $editorConfigFactory;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('fix');
        $this->setDescription('Fix files based on .editorconfig');
        $this->addArgument('paths', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Path to analyze');
        $this->addOption('suffix', null, InputOption::VALUE_REQUIRED, 'File suffix to fix');
    }
    /**
     * @return self::FAILURE|self::SUCCESS
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $paths = (array) $input->getArgument('paths');
        $fileSuffix = $this->resolveSuffix($input);
        $editorConfigFilePath = \getcwd() . '/.editorconfig';
        $specificFileEditorConfig = $this->editorConfigFactory->createFromFilePath($editorConfigFilePath, $fileSuffix);
        $filePaths = $this->phpFilesFinder->findInDirectories($paths, $fileSuffix);
        if ($filePaths === []) {
            $this->symfonyStyle->error('No files found to scan');
            return Command::FAILURE;
        }
        $progressBar = $this->createProgressBar($filePaths);
        $fixedFilePaths = [];
        foreach ($filePaths as $filePath) {
            $progressBar->advance();
            $fileContents = \file_get_contents($filePath);
            Assert::string($fileContents);
            $fixedFileContents = $this->indentionFixer->fixContent($fileContents, $specificFileEditorConfig);
            if ($fileContents === $fixedFileContents) {
                continue;
            }
            \file_put_contents($filePath, $fixedFileContents);
            $fixedFilePaths[] = $filePath;
        }
        if ($fixedFilePaths !== []) {
            $this->symfonyStyle->newLine(1);
            $this->symfonyStyle->title('Fixed files');
            foreach ($fixedFilePaths as $fixedFilePath) {
                $this->symfonyStyle->writeln(' * ' . FilePathHelper::relative($fixedFilePath));
            }
        }
        $this->symfonyStyle->newLine();
        $this->symfonyStyle->success('All files are fixed');
        return Command::SUCCESS;
    }
    /**
     * @param string[] $filePaths
     */
    private function createProgressBar(array $filePaths) : ProgressBar
    {
        $progressBar = $this->symfonyStyle->createProgressBar(\count($filePaths));
        $progressBar->start();
        return $progressBar;
    }
    private function resolveSuffix(InputInterface $input) : string
    {
        $suffix = $input->getOption('suffix');
        if ($suffix === '') {
            throw new ShouldNotHappenException('Fill the suffix, e.g. "--suffix yaml"');
        }
        if (!\preg_match(self::FILE_SUFFIX_PATTERN, $suffix)) {
            throw new ShouldNotHappenException(\sprintf('The suffix "%s" is not valid. Provide 3-4 alpha chars, e.g. "json", "php" or "yml".', $suffix));
        }
        return $suffix;
    }
}
