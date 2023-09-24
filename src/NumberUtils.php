<?php

declare (strict_types=1);
namespace EditorconfigFixer202309\TomasVotruba\EditorconfigFixer;

use EditorconfigFixer202309\Webmozart\Assert\Assert;
/**
 * @see \TomasVotruba\EditorconfigFixer\Tests\NumberUtilsTest
 */
final class NumberUtils
{
    /**
     * @param int[] $numbers
     */
    public static function resolveGreatestCommonDivisor(array $numbers) : int
    {
        Assert::notEmpty($numbers);
        /** @var int $greatestCommonDivisor */
        $greatestCommonDivisor = \array_pop($numbers);
        foreach ($numbers as $number) {
            $greatestCommonDivisor = self::calculateGreatestCommonDivisor($greatestCommonDivisor, $number);
        }
        return $greatestCommonDivisor;
    }
    private static function calculateGreatestCommonDivisor(int $firstNumber, int $secondNumber) : int
    {
        $firstNumber = \abs($firstNumber);
        $secondNumber = \abs($secondNumber);
        while ($secondNumber !== 0) {
            $remainder = $firstNumber % $secondNumber;
            $firstNumber = $secondNumber;
            $secondNumber = $remainder;
        }
        return $firstNumber;
    }
}
