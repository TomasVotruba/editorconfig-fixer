<?php

declare(strict_types=1);

namespace Fixer\IndentationFixer;

use Iterator;
use PHPUnit\Framework\Attributes\DataProvider;
use TomasVotruba\EditorconfigFixer\EditorConfig\EditorConfig;
use TomasVotruba\EditorconfigFixer\Fixer\IndentationFixer;
use TomasVotruba\EditorconfigFixer\Tests\AbstractTestCase;

final class IndentationFixerTest extends AbstractTestCase
{
    private IndentationFixer $indentationFixer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->indentationFixer = $this->make(IndentationFixer::class);
    }

    #[DataProvider('provideData')]
    public function test(string $filePath, string $fixedFilePath): void
    {
        /** @var string $fileContents */
        $fileContents = file_get_contents($filePath);

        $fixedFileContent = $this->indentationFixer->fixContent($fileContents, new EditorConfig(4));
        $this->assertStringEqualsFile($fixedFilePath, $fixedFileContent);
    }

    public static function provideData(): Iterator
    {
        yield [__DIR__ . '/Fixture/some_file.yaml', __DIR__ . '/Fixture/fixed_some_file.yaml'];

        // there is single space typo here
        yield [__DIR__ . '/Fixture/typoed_some_file.yaml', __DIR__ . '/Fixture/fixed_typoed_some_file.yaml'];
    }
}
