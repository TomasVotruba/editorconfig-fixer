<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\EditorConfig;

use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\NumberUtils;
use EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\StringUtils;
final class IndentionFixer
{
    public function fixContent(string $content, EditorConfig $editorConfig) : string
    {
        $lineEnding = $this->resolveLineEnding($content);
        /** @var array<int, string> $lines */
        $lines = \explode($lineEnding, $content);
        $currentIndentSize = $this->resolveCurrentIndentSize($lines);
        $indentSizeRatio = $editorConfig->getIndentSize() / $currentIndentSize;
        // nothing to change
        if ($indentSizeRatio === 1) {
            return $content;
        }
        foreach ($lines as $key => $line) {
            // handle spaces only
            $matches = StringUtils::match($line, '#^[ ]+#');
            if ($matches === []) {
                continue;
            }
            $leadingSpaceIndentContent = $matches[0];
            $leadingSpaceIndentCount = \substr_count((string) $leadingSpaceIndentContent, ' ');
            $fixedLeadingSpaceIndentCount = (int) ($leadingSpaceIndentCount * $indentSizeRatio);
            $fixedLeadingSpaceIndentContent = \str_repeat(' ', $fixedLeadingSpaceIndentCount);
            $lines[$key] = $fixedLeadingSpaceIndentContent . \ltrim($line);
        }
        return \implode($lineEnding, $lines);
    }
    private function resolveLineEnding(string $fileContents) : string
    {
        // Detect line endings using regular expressions
        if (\preg_match("/\r\n/", $fileContents)) {
            return "\r\n";
        }
        if (\preg_match("/\r/", $fileContents)) {
            return "\r";
        }
        return "\n";
    }
    /**
     * @param array<int, string> $contentLines
     */
    private function resolveCurrentIndentSize(array $contentLines) : int
    {
        $knownIndentSizes = [];
        foreach ($contentLines as $contentLine) {
            $leadingIndent = StringUtils::match($contentLine, '#^[ \\t]+#');
            if ($leadingIndent === []) {
                continue;
            }
            $knownIndentSizes[] = \strlen((string) $leadingIndent[0]);
        }
        return NumberUtils::resolveGreatestCommonDivisor($knownIndentSizes);
    }
}
