<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\Idiosyncratic\EditorConfig\Declaration;

use EditorconfigFixer202309\Idiosyncratic\EditorConfig\Exception\InvalidValue;
use EditorconfigFixer202309\PHPUnit\Framework\TestCase;
use RuntimeException;
class InsertFinalNewlineTest extends TestCase
{
    public function testValidValues()
    {
        $declaration = new InsertFinalNewline('false');
        $this->assertEquals('insert_final_newline=false', (string) $declaration);
        $declaration = new InsertFinalNewline('true');
        $this->assertEquals('insert_final_newline=true', (string) $declaration);
    }
    public function testInvalidValues()
    {
        $this->expectException(InvalidValue::class);
        $declaration = new InsertFinalNewline('4');
        $this->expectException(InvalidValue::class);
        $declaration = new InsertFinalNewline('four');
    }
}
