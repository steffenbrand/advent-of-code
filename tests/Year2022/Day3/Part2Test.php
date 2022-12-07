<?php

namespace AoC\Tests\Year2022\Day3;

use AoC\Year2022\Day3\Part2;
use PHPUnit\Framework\TestCase;

class Part2Test extends TestCase
{
    public function getSut(): Part2
    {
        return new Part2();
    }

    /**
     * @dataProvider provideData
     */
    public function testSolve(string $filePath, int $expected): void
    {
        $actual = $this->getSut()->solve(file_get_contents($filePath));

        self::assertSame($expected, $actual);
    }

    public function provideData(): array
    {
        return [
            [
                __DIR__ . '/../../../resources/Year2022/Day3/sample.txt',
                70
            ],
            [
                __DIR__ . '/../../../resources/Year2022/Day3/puzzle.txt',
                2607
            ]
        ];
    }
}
