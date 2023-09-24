<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\Idiosyncratic\EditorConfig\Declaration;

final class TrimTrailingWhitespace extends BooleanDeclaration
{
    public function getName() : string
    {
        return 'trim_trailing_whitespace';
    }
}
