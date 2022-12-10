<?php

declare(strict_types=1);

namespace AoC\Year2022\Day9;

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
        $this->markPositionVisited();
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
        $requiredMovements = $this->determineRequiredMovements($parent);

        foreach ($requiredMovements as $direction => $required) {
            if ($required) {
                $this->move($direction);
            }
        }

        $this->markPositionVisited();

        $this->getChild()?->follow($this);
    }

    private function determineRequiredMovements(Position $parent): array
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

    private function parentAndChildAreInLine(Position $parent): bool
    {
        return
            $parent->getHorizontal() === $this->getHorizontal() ||
            $parent->getVertical() === $this->getVertical();
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