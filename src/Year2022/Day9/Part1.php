<?php

declare(strict_types=1);

namespace AoC\Year2022\Day9;

class Part1
{
    private Position $headPosition;
    private Position $tailPosition;
    private array $positionsVisitedByTail = [];

    public function __construct()
    {
        $this->headPosition = new Position(0,0);
        $this->tailPosition = new Position(0,0);
    }

    public function solve(string $puzzle): int
    {
        $this->positionsVisitedByTail['v0h0'] = 1;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $movement = explode(' ', $line);
            $direction = $movement[0];
            $steps = (int) $movement[1];
            $this->move($direction, $steps);
        }

        return count($this->positionsVisitedByTail);
    }

    private function move(string $direction, int $steps): void
    {
        for ($i = 1; $i <= $steps; $i++) {
            $this->updateHeadPosition($direction);
            $this->updateTailPosition();
        }
    }

    private function updateHeadPosition(string $direction): void
    {
        // calculate new head position
    }

    private function updateTailPosition(): void
    {
        // get current head position
        // determine where to move
        // update tail position
        $this->positionsVisitedByTail[$this->tailPosition->getUniqueIdentifier()] = 1;
    }
}