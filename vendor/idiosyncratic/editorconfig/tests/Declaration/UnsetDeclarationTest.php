<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\Idiosyncratic\EditorConfig\Declaration;

use DomainException;
use ErrorException;
use EditorconfigFixer202309\PHPUnit\Framework\TestCase;
use RuntimeException;
class UnsetDeclarationTest extends TestCase
{
    public function testDeclaration()
    {
        $declaration = new UnsetDeclaration('indent_style');
        $this->assertEquals('indent_style', $declaration->getName());
        $this->assertNull($declaration->getValue());
        $this->assertEquals('indent_style=unset', (string) $declaration);
    }
}
