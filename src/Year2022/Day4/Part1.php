<?php

declare(strict_types=1);

namespace AoC\Year2022\Day4;

class Part1
{
    public function solve(string $puzzle): int
    {
        $sum = 0;

        foreach (explode(PHP_EOL, $puzzle) as $pair) {
            $ranges = explode(',', $pair);
            $range1 = explode('-', $ranges[0]);
            $range2 = explode('-', $ranges[1]);
            if (($range1[0] <= $range2[0] && $range1[1] >= $range2[1]) ||
                ($range1[0] >= $range2[0] && $range1[1] <= $range2[1])
            ) {
                $sum++;
            }
        }

        return $sum;
    }
}