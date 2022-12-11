<?php

namespace AoC\Tests\Year2022\Day11;

use AoC\Year2022\Day11\Part1;
use PHPUnit\Framework\TestCase;

class Part1Test extends TestCase
{
    public function getSut(): Part1
    {
        return new Part1();
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
                __DIR__ . '/../../../resources/Year2022/Day11/sample.txt',
                10605
            ],
            [
                __DIR__ . '/../../../resources/Year2022/Day11/puzzle.txt',
                54054
            ]
        ];
    }
}
