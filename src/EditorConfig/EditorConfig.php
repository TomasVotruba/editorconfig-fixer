<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer\EditorConfig;

final class EditorConfig
{
    /**
     * @readonly
     * @var int
     */
    private $indentSize;
    public function __construct(int $indentSize)
    {
        $this->indentSize = $indentSize;
    }
    public function getIndentSize() : int
    {
        return $this->indentSize;
    }
}
