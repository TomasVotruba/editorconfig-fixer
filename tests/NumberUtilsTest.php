<?php

declare(strict_types=1);

namespace TomasVotruba\EditorconfigFixer\Tests;

use PHPUnit\Framework\TestCase;
use TomasVotruba\EditorconfigFixer\NumberUtils;

final class NumberUtilsTest extends TestCase
{
    public function test(): void
    {
        $greatestCommonDivisor = NumberUtils::resolveGreatestCommonDivisor([4, 8, 16]);

        $this->assertSame(4, $greatestCommonDivisor);
    }
}
