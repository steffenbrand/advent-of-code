<?php

declare(strict_types=1);

namespace AoC\Year2022\Day13;

class Part1
{
    public function solve(string $puzzle): int
    {
        $sum = 0;

        $i = 1;
        foreach (explode(PHP_EOL.PHP_EOL, $puzzle) as $packets) {
            $packets = explode(PHP_EOL, $packets);

            if ($this->comparePackets($packets[0], $packets[1]) < 1) {
                $sum += $i;
            }

            $i++;
        }

        return $sum;
    }

    private function comparePackets($left, $right): int
    {
        $left = json_decode($left, false, 512, JSON_THROW_ON_ERROR);
        $right = json_decode($right, false, 512, JSON_THROW_ON_ERROR);

        if (is_int($left) && is_int($right)) {
            return $left <=> $right;
        }

        if (is_int($left) && is_array($right)) {
            $left = [$left];
        }

        if (is_array($left) && is_int($right)) {
            $right = [$right];
        }

        while (count($left) && count($right)) {
            $nextLeft = array_shift($left);
            $nextRight = array_shift($right);

            if ($result = $this->comparePackets(json_encode($nextLeft), json_encode($nextRight))) {
                return $result;
            }
        }

        return count($left) - count($right);
    }

}
