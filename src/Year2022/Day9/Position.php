<?php

declare(strict_types=1);

namespace AoC\Year2022\Day9;

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
        return sprintf('v%dh%d', $this->horizontal, $this->vertical);
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