<?php

namespace AoC\Tests\Year2022\Day6;

use AoC\Year2022\Day6\Part1;
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
                __DIR__ . '/../../../resources/Year2022/Day6/sample.txt',
                7
            ],
            [
                __DIR__ . '/../../../resources/Year2022/Day6/puzzle.txt',
                1175
            ]
        ];
    }
}
