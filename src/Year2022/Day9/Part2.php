<?php

declare(strict_types=1);

namespace AoC\Year2022\Day9;

class Part2
{
    private const KNOTS = 10;

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

class Position
{
    private const MAX_ALLOWED_DISTANCE = 1;

    private const DIRECTION_UP = 'U';
    private const DIRECTION_DOWN = 'D';
    private const DIRECTION_LEFT = 'L';
    private const DIRECTION_RIGHT = 'R';

    private int $vertical;
    private int $horizontal;
    private ?Position $child = null;
    private array $visitedPositions = [];

    public function __construct(int $vertical, int $horizontal)
    {
        $this->horizontal = $horizontal;
        $this->vertical = $vertical;
        $this->visitedPositions[$this->getUniqueIdentifier()] = 1;
    }

    public function move(string $direction): void
    {
        switch ($direction) {
            case self::DIRECTION_UP:
                $this->setVertical($this->getVertical() + 1);
                break;
            case self::DIRECTION_DOWN:
                $this->setVertical($this->getVertical() - 1);
                break;
            case self::DIRECTION_LEFT:
                $this->setHorizontal($this->getHorizontal() - 1);
                break;
            case self::DIRECTION_RIGHT:
                $this->setHorizontal($this->getHorizontal() + 1);
                break;
        }
    }

    public function follow(Position $parent): void
    {
        $requiredMovements = $this->calculateRequiredMovements($parent);

        foreach ($requiredMovements as $direction => $required) {
            if ($required) {
                $this->move($direction);
            }
        }

        if ($this->getChild()) {
            $this->getChild()->follow($this);
        } else {
            $this->markPositionVisited();
        }
    }

    private function calculateRequiredMovements(Position $parent): array
    {
        $requiredMovements = [
            self::DIRECTION_RIGHT => false,
            self::DIRECTION_LEFT => false,
            self::DIRECTION_UP => false,
            self::DIRECTION_DOWN => false,
        ];

        if ($this->parentIsTooFarRightOfChild($parent)) {
            $requiredMovements[self::DIRECTION_RIGHT] = true;
        }

        if ($this->parentIsTooFarLeftOfChild($parent)) {
            $requiredMovements[self::DIRECTION_LEFT] = true;
        }

        if ($this->parentIsTooFarAboveChild($parent)) {
            $requiredMovements[self::DIRECTION_UP] = true;
        }

        if ($this->parentIsTooFarBelowChild($parent)) {
            $requiredMovements[self::DIRECTION_DOWN] = true;
        }

        if (false === $requiredMovements[self::DIRECTION_RIGHT] &&
            false === $requiredMovements[self::DIRECTION_LEFT] &&
            false === $requiredMovements[self::DIRECTION_UP] &&
            false === $requiredMovements[self::DIRECTION_DOWN]
        ) {
            return $requiredMovements;
        }

        if (!$this->parentAndChildAreInLine($parent)) {
            if (!$requiredMovements[self::DIRECTION_RIGHT] && $parent->getHorizontal() > $this->getHorizontal()) {
                $requiredMovements[self::DIRECTION_RIGHT] = true;
            }

            if (!$requiredMovements[self::DIRECTION_LEFT] && $this->getHorizontal() > $parent->getHorizontal()) {
                $requiredMovements[self::DIRECTION_LEFT] = true;
            }

            if (!$requiredMovements[self::DIRECTION_UP] && $parent->getVertical() > $this->getVertical()) {
                $requiredMovements[self::DIRECTION_UP] = true;
            }

            if (!$requiredMovements[self::DIRECTION_DOWN] && $this->getVertical() > $parent->getVertical()) {
                $requiredMovements[self::DIRECTION_DOWN] = true;
            }
        }

        return $requiredMovements;
    }

    private function parentAndChildAreInLine(Position $parent): bool
    {
        return
            $parent->getHorizontal() === $this->getHorizontal() ||
            $parent->getVertical() === $this->getVertical();
    }

    private function parentIsTooFarRightOfChild(Position $parent): bool
    {
        return $parent->getHorizontal() - $this->getHorizontal() > self::MAX_ALLOWED_DISTANCE;
    }

    private function parentIsTooFarLeftOfChild(Position $parent): bool
    {
        return $this->getHorizontal() - $parent->getHorizontal() > self::MAX_ALLOWED_DISTANCE;
    }

    private function parentIsTooFarAboveChild(Position $parent): bool
    {
        return $parent->getVertical() - $this->getVertical() > self::MAX_ALLOWED_DISTANCE;
    }

    private function parentIsTooFarBelowChild(Position $parent): bool
    {
        return $this->getVertical() - $parent->getVertical() > self::MAX_ALLOWED_DISTANCE;
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

    public function setChild(Position $child): void
    {
        $this->child = $child;
    }

    public function getChild(): ?Position
    {
        return $this->child;
    }

    private function markPositionVisited(): void
    {
        $this->visitedPositions[$this->getUniqueIdentifier()] = 1;
    }

    public function countVisitedPositions(): int
    {
        return count($this->visitedPositions);
    }
}