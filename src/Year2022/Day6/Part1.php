<?php

declare(strict_types=1);

namespace AoC\Year2022\Day6;

class Part1
{
    private const SIGNAL_LENGTH = 4;

    public function solve(string $puzzle): int
    {
        $i = 0;

        while (self::SIGNAL_LENGTH !== count(array_unique(str_split(substr($puzzle, $i, self::SIGNAL_LENGTH))))) {
            $i++;
        }

        return $i + self::SIGNAL_LENGTH;
    }
}