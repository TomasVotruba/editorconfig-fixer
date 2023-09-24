<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\EditorConfig;

use Idiosyncratic\EditorConfig\Declaration\Declaration;
use Idiosyncratic\EditorConfig\Declaration\IndentSize;
use Idiosyncratic\EditorConfig\EditorConfigFile;
use Webmozart\Assert\Assert;

/**
 * @see \TomasVotruba\EditorconfigFixer\Tests\EditorConfig\EditorConfigFactoryTest
 */
final class EditorConfigFactory
{
    public function createFromFilePath(string $filePath, string $fileSuffix): EditorConfig
    {
        Assert::fileExists($filePath);

        $editorConfigFile = new EditorConfigFile($filePath);

        $editorConfigFriendlySuffix = '\.' . $fileSuffix;
        $specificFileEditorConfig = $editorConfigFile->getConfigForPath($editorConfigFriendlySuffix);

        $indentSizeValue = $this->resolveIndentSizeValue($specificFileEditorConfig);
        return new EditorConfig($indentSizeValue);
    }

    /**
     * @param array<string, Declaration> $config
     */
    private function resolveIndentSizeValue(array $config): int
    {
        $indentSize = $config['indent_size'] ?? null;
        if ($indentSize instanceof IndentSize) {
            return (int) $indentSize->getValue();
        }

        // default indent size
        return 4;
    }
}
