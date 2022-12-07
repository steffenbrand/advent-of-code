<?php

declare(strict_types=1);

namespace AoC\Year2022\Day1;

class Part2
{
    public function solve(string $puzzle): int
    {
        $elves = [];
        $currentElv = 1;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            if ((int) $line > 0) {
                if (!array_key_exists($currentElv, $elves)) {
                    $elves[$currentElv] = 0;
                }
                $elves[$currentElv] += (int) $line;
                continue;
            }

            $currentElv++;
        }

        arsort($elves);

        $i = 0;
        $sum = 0;
        foreach ($elves as $kcal) {
            $sum += $kcal;

            if ($i >= 2) {
                break;
            }

            $i++;
        }

        return $sum;
    }
}