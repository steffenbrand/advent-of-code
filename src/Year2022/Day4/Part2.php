<?php

declare(strict_types=1);

namespace AoC\Year2022\Day4;

class Part2
{
    public function solve(string $puzzle): int
    {
        $sum = 0;

        foreach (explode(PHP_EOL, $puzzle) as $pair) {
            $ranges = explode(',', $pair);
            $range1 = range(explode('-', $ranges[0])[0], explode('-', $ranges[0])[1]);
            $range2 = range(explode('-', $ranges[1])[0], explode('-', $ranges[1])[1]);
            foreach ($range1 as $a) {
                if (in_array($a, $range2, true)) {
                    $sum++;
                    break;
                }
            }
        }

        return $sum;
    }
}