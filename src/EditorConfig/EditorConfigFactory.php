<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\EditorConfig;

use EditorconfigFixer202309\Idiosyncratic\EditorConfig\Declaration\Declaration;
use EditorconfigFixer202309\Idiosyncratic\EditorConfig\Declaration\IndentSize;
use EditorconfigFixer202309\Idiosyncratic\EditorConfig\EditorConfigFile;
use EditorconfigFixer202309\Webmozart\Assert\Assert;
/**
 * @see \TomasVotruba\EditorconfigFixer\Tests\EditorConfig\EditorConfigFactoryTest
 */
final class EditorConfigFactory
{
    public function createFromFilePath(string $filePath, string $fileSuffix) : EditorConfig
    {
        Assert::fileExists($filePath);
        $editorConfigFile = new EditorConfigFile($filePath);
        $editorConfigFriendlySuffix = '\\.' . $fileSuffix;
        $specificFileEditorConfig = $editorConfigFile->getConfigForPath($editorConfigFriendlySuffix);
        $indentSizeValue = $this->resolveIndentSizeValue($specificFileEditorConfig);
        return new EditorConfig($indentSizeValue);
    }
    /**
     * @param array<string, Declaration> $config
     */
    private function resolveIndentSizeValue(array $config) : int
    {
        $indentSize = $config['indent_size'] ?? null;
        if ($indentSize instanceof IndentSize) {
            return (int) $indentSize->getValue();
        }
        // default indent size
        return 4;
    }
}
