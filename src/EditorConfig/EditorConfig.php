<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\EditorConfig;

final class EditorConfig
{
    public function __construct(
        private readonly int $indentSize
    ) {
    }

    public function getIndentSize(): int
    {
        return $this->indentSize;
    }
}
