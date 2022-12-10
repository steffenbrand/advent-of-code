<?php

declare(strict_types=1);

namespace AoC\Year2022\Day10;

class Part1
{
    public function solve(string $puzzle): int
    {
        $sum = 0;
        $x = 1;
        $cycle = 0;
        $ofInterest = 20;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $instruction = Instruction::createFromLine($line);

            while ($instruction->inExecution()) {
                $cycle++;
                $instruction->increaseCycleNumber();

                if ($cycle % $ofInterest === 0) {
                    $sum += $cycle * $x;
                    if ($cycle === $ofInterest) {
                        $ofInterest += 40;
                    }
                }
            }

            $x += $instruction->getValue();
        }

        return $sum;
    }
}