<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer;

final class FilePathHelper
{
    public static function relative(string $filePath): string
    {
        // make path relative with native PHP
        $relativeFilePath = (string) realpath($filePath);

        return str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $relativeFilePath);
    }
}
