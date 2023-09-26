<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\Idiosyncratic\EditorConfig\Declaration;

use EditorconfigFixer202309\Idiosyncratic\EditorConfig\Exception\InvalidValue;
use EditorconfigFixer202309\PHPUnit\Framework\TestCase;
use RuntimeException;
class IndentStyleTest extends TestCase
{
    public function testValidValues()
    {
        $declaration = new IndentStyle('tab');
        $this->assertEquals('indent_style', $declaration->getName());
        $this->assertEquals('tab', $declaration->getValue());
        $declaration = new IndentStyle('space');
        $this->assertEquals('indent_style', $declaration->getName());
        $this->assertEquals('space', $declaration->getValue());
    }
    public function testInvalidValues()
    {
        $this->expectException(InvalidValue::class);
        $declaration = new IndentStyle('true');
        $this->expectException(InvalidValue::class);
        $declaration = new IndentStyle('spaces');
    }
}
