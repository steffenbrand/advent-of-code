<?php

declare(strict_types=1);

namespace AoC\Year2022\Day8;

class Part1
{
    private array $forrest = [];
    private int $rowCount = 0;
    private int $columnCount = 0;

    public function solve(string $puzzle): int
    {
        $sum = 0;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $this->forrest[] = str_split($line);
        }

        $this->rowCount = count($this->forrest);
        $this->columnCount = count($this->forrest[0]);

        foreach ($this->forrest as $row => $columns) {
            foreach ($columns as $column => $height) {
                if ($this->isVisible($row, $column, (int) $height)) {
                    $sum++;
                }
            }
        }

        return $sum;
    }

    private function isVisible(int $row, int $column, int $height): bool
    {
        if ($this->isEdgePosition($row, $column)) {
            return true;
        }

        if ($this->isVisibleFromTop($row, $column, $height)) {
            return true;
        }

        if ($this->isVisibleFromBelow($row, $column, $height)) {
            return true;
        }

        if ($this->isVisibleFromLeft($row, $column, $height)) {
            return true;
        }

        if ($this->isVisibleFromRight($row, $column, $height)) {
            return true;
        }

        return false;
    }

    private function isEdgePosition(int $row, int $column): bool
    {
        return 0 === $row
            || $this->rowCount - 1 === $row
            || 0 === $column
            || $this->columnCount - 1 === $column;
    }

    private function isVisibleFromTop(int $row, int $column, int $height): bool
    {
        $currentRow = $row - 1;

        while ($currentRow >= 0) {
            if ($height <= $this->forrest[$currentRow][$column]) {
                return false;
            }
            $currentRow--;
        }

        return true;
    }

    private function isVisibleFromBelow(int $row, int $column, int $height): bool
    {
        $currentRow = $row + 1;

        while ($currentRow <= $this->rowCount - 1) {
            if ($height <= $this->forrest[$currentRow][$column]) {
                return false;
            }
            $currentRow++;
        }

        return true;
    }

    private function isVisibleFromLeft(int $row, int $column, int $height): bool
    {
        $currentColumn = $column - 1;

        while ($currentColumn >= 0) {
            if ($height <= $this->forrest[$row][$currentColumn]) {
                return false;
            }
            $currentColumn--;
        }

        return true;
    }

    private function isVisibleFromRight(int $row, int $column, int $height): bool
    {
        $currentColumn = $column + 1;

        while ($currentColumn <= $this->columnCount - 1) {
            if ($height <= $this->forrest[$row][$currentColumn]) {
                return false;
            }
            $currentColumn++;
        }

        return true;
    }
}