<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer;

final class StringUtils
{
    /**
     * @return array<int|string, mixed>
     */
    public static function match(string $content, string $regex) : array
    {
        \preg_match($regex, $content, $matches);
        return $matches;
    }
}
