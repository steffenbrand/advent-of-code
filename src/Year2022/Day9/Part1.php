<?php

declare(strict_types=1);

namespace AoC\Year2022\Day9;

class Part1
{
    private const MAX_ALLOWED_DISTANCE = 1;

    private const DIRECTION_UP = 'U';
    private const DIRECTION_DOWN = 'D';
    private const DIRECTION_LEFT = 'L';
    private const DIRECTION_RIGHT = 'R';

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
        $this->markPositionVisitedByTail();

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
        switch ($direction) {
            case self::DIRECTION_UP:
                $this->headPosition->setVertical($this->headPosition->getVertical() + 1);
                break;
            case self::DIRECTION_DOWN:
                $this->headPosition->setVertical($this->headPosition->getVertical() - 1);
                break;
            case self::DIRECTION_LEFT:
                $this->headPosition->setHorizontal($this->headPosition->getHorizontal() - 1);
                break;
            case self::DIRECTION_RIGHT:
                $this->headPosition->setHorizontal($this->headPosition->getHorizontal() + 1);
                break;
        }
    }

    private function updateTailPosition(): void
    {
        if ($this->headAndTailAreInTheSamePlace()) {
            return;
        }

        $requiredMovements = [
            self::DIRECTION_RIGHT => false,
            self::DIRECTION_LEFT => false,
            self::DIRECTION_UP => false,
            self::DIRECTION_DOWN => false,
        ];

        if ($this->headIsTooFarRightOfTail()) {
            $requiredMovements[self::DIRECTION_RIGHT] = true;
        }

        if ($this->headIsTooFarLeftOfTail()) {
            $requiredMovements[self::DIRECTION_LEFT] = true;
        }

        if ($this->headIsTooFarAboveTail()) {
            $requiredMovements[self::DIRECTION_UP] = true;
        }

        if ($this->headIsTooFarBelowTail()) {
            $requiredMovements[self::DIRECTION_DOWN] = true;
        }

        if (false === $requiredMovements[self::DIRECTION_RIGHT] &&
            false === $requiredMovements[self::DIRECTION_LEFT] &&
            false === $requiredMovements[self::DIRECTION_UP] &&
            false === $requiredMovements[self::DIRECTION_DOWN]
        ) {
            return;
        }

        if (!$this->headAndTailAreInLine()) {
            if (!$requiredMovements[self::DIRECTION_RIGHT] &&
                $this->headPosition->getHorizontal() > $this->tailPosition->getHorizontal())
            {
                $requiredMovements[self::DIRECTION_RIGHT] = true;
            }

            if (!$requiredMovements[self::DIRECTION_LEFT] &&
                $this->tailPosition->getHorizontal() > $this->headPosition->getHorizontal())
            {
                $requiredMovements[self::DIRECTION_LEFT] = true;
            }

            if (!$requiredMovements[self::DIRECTION_UP] &&
                $this->headPosition->getVertical() > $this->tailPosition->getVertical())
            {
                $requiredMovements[self::DIRECTION_UP] = true;
            }

            if (!$requiredMovements[self::DIRECTION_DOWN] &&
                $this->tailPosition->getVertical() > $this->headPosition->getVertical())
            {
                $requiredMovements[self::DIRECTION_DOWN] = true;
            }
        }

        foreach ($requiredMovements as $direction => $required) {
            if (!$required) {
                continue;
            }

            switch ($direction) {
                case self::DIRECTION_UP:
                    $this->tailPosition->setVertical($this->tailPosition->getVertical() + 1);
                    break;
                case self::DIRECTION_DOWN:
                    $this->tailPosition->setVertical($this->tailPosition->getVertical() - 1);
                    break;
                case self::DIRECTION_LEFT:
                    $this->tailPosition->setHorizontal($this->tailPosition->getHorizontal() - 1);
                    break;
                case self::DIRECTION_RIGHT:
                    $this->tailPosition->setHorizontal($this->tailPosition->getHorizontal() + 1);
                    break;
            }
        }

        $this->markPositionVisitedByTail();
    }

    private function markPositionVisitedByTail(): void
    {
        $this->positionsVisitedByTail[$this->tailPosition->getUniqueIdentifier()] = 1;
    }


    private function headAndTailAreInTheSamePlace(): bool
    {
        return
            $this->headPosition->getHorizontal() === $this->tailPosition->getHorizontal() &&
            $this->headPosition->getVertical() === $this->tailPosition->getVertical();
    }

    private function headAndTailAreInLine(): bool
    {
        return
            $this->headPosition->getHorizontal() === $this->tailPosition->getHorizontal() ||
            $this->headPosition->getVertical() === $this->tailPosition->getVertical();
    }

    private function headIsTooFarRightOfTail(): bool
    {
        return $this->headPosition->getHorizontal() - $this->tailPosition->getHorizontal() > self::MAX_ALLOWED_DISTANCE;
    }

    private function headIsTooFarLeftOfTail(): bool
    {
        return $this->tailPosition->getHorizontal() - $this->headPosition->getHorizontal() > self::MAX_ALLOWED_DISTANCE;
    }

    private function headIsTooFarAboveTail(): bool
    {
        return $this->headPosition->getVertical() - $this->tailPosition->getVertical() > self::MAX_ALLOWED_DISTANCE;
    }

    private function headIsTooFarBelowTail(): bool
    {
        return $this->tailPosition->getVertical() - $this->headPosition->getVertical() > self::MAX_ALLOWED_DISTANCE;
    }
}

class Position
{
    private int $vertical;
    private int $horizontal;

    public function __construct(int $vertical, int $horizontal)
    {
        $this->horizontal = $horizontal;
        $this->vertical = $vertical;
    }

    public function getUniqueIdentifier(): string
    {
        return sprintf('h%dv%d', $this->horizontal, $this->vertical);
    }

    public function getHorizontal(): int
    {
        return $this->horizontal;
    }

    public function setHorizontal(int $horizontal): void
    {
        $this->horizontal = $horizontal;
    }

    public function getVertical(): int
    {
        return $this->vertical;
    }

    public function setVertical(int $vertical): void
    {
        $this->vertical = $vertical;
    }
}