<?php

declare(strict_types=1);

namespace AoC\Year2022\Day1;

class Part1
{
    public function solve(string $puzzle): int
    {
        $elves = [];
        $currentElv = 1;
        $mostKcalElv = null;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            if ((int) $line > 0) {
                if (!array_key_exists($currentElv, $elves)) {
                    $elves[$currentElv] = 0;
                }
                $elves[$currentElv] += (int) $line;
                continue;
            }

            if (!$mostKcalElv || $elves[$currentElv] > $elves[$mostKcalElv]) {
                $mostKcalElv = $currentElv;
            }

            $currentElv++;
        }

        return $elves[$mostKcalElv];
    }
}