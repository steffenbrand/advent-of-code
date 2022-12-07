<?php

declare(strict_types=1);

namespace AoC\Year2022\Day3;

class Part1
{
    private array $priorities;

    public function __construct()
    {
        $this->priorities = $this->createPriorities();
    }

    public function solve(string $puzzle): int
    {
        $sum = 0;

        foreach (explode(PHP_EOL, $puzzle) as $rucksack) {
            $compartments = str_split($rucksack, strlen($rucksack)/2);
            foreach (str_split($compartments[0]) as $item) {
                if (false !== strpos($compartments[1], $item)) {
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