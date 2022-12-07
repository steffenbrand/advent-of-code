<?php

declare(strict_types=1);

namespace AoC\Year2022\Day3;

class Part2
{
    private array $priorities;

    public function __construct()
    {
        $this->priorities = $this->createPriorities();
    }

    public function solve(string $puzzle): int
    {
        $sum = 0;

        $groups = array_chunk(explode(PHP_EOL, $puzzle), 3);

        foreach ($groups as $group) {
            foreach (str_split($group[0]) as $item) {
                if (false !== strpos($group[1], $item) &&
                    false !== strpos($group[2], $item)
                ) {
                    $sum += $this->priorities[$item];
                    break;
                }
            }
        }

        return $sum;
    }

    private function createPriorities(): array
    {
        $letters = range('a', 'z');
        $letterCount = count($letters);

        $i = 1;
        foreach ($letters as $letter) {
            $priorities[$letter] = $i;
            $priorities[strtoupper($letter)] = $i + $letterCount;
            $i++;
        }

        return $priorities;
    }
}