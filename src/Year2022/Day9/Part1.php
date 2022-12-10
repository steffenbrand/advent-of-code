<?php

declare(strict_types=1);

namespace AoC\Year2022\Day9;

class Part1
{
    private const KNOTS = 2;

    /**
     * @var Position[]
     */
    private array $knots = [];

    public function __construct()
    {
        for ($i = 0; $i < self::KNOTS; $i++) {
            $this->knots[$i] = new Position(0, 0);
            if (count($this->knots) > 1) {
                $this->knots[$i-1]->setChild($this->knots[$i]);
            }
        }
    }

    public function solve(string $puzzle): int
    {
        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $movement = explode(' ', $line);
            $direction = $movement[0];
            $steps = (int) $movement[1];
            $this->move($direction, $steps);
        }

        return $this->knots[self::KNOTS - 1]->countVisitedPositions();
    }

    private function move(string $direction, int $steps): void
    {
        for ($i = 1; $i <= $steps; $i++) {
            $this->knots[0]->move($direction);
            $this->knots[0]->getChild()?->follow($this->knots[0]);
        }
    }
}