<?php

declare(strict_types=1);

namespace AoC\Year2022\Day8;

class Part2
{
    private array $forrest = [];
    private int $rowCount = 0;
    private int $columnCount = 0;

    public function solve(string $puzzle): int
    {
        $highestScore = 0;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $this->forrest[] = str_split($line);
        }

        $this->rowCount = count($this->forrest);
        $this->columnCount = count($this->forrest[0]);

        foreach ($this->forrest as $row => $columns) {
            foreach ($columns as $column => $height) {
                $score = $this->calculateScore($row, $column, (int) $height);
                if ($score > $highestScore) {
                    $highestScore = $score;
                }
            }
        }

        return $highestScore;
    }

    private function calculateScore(int $row, int $column, int $height): int
    {
        if ($this->isEdgePosition($row, $column)) {
            return 0;
        }

        $up = $this->lookUp($row, $column, $height);
        $down = $this->lookDown($row, $column, $height);
        $left = $this->lookLeft($row, $column, $height);
        $right = $this->lookRight($row, $column, $height);

        return $up * $down * $left * $right;
    }

    private function lookUp(int $row, int $column, int $height): int
    {
        $visibleTrees = 0;
        $currentRow = $row - 1;

        while ($currentRow >= 0) {
            $visibleTrees++;
            if ($height <= $this->forrest[$currentRow][$column]) {
                break;
            }
            $currentRow--;
        }

        return $visibleTrees;
    }

    private function lookDown(int $row, int $column, int $height): int
    {
        $visibleTrees = 0;
        $currentRow = $row + 1;

        while ($currentRow <= $this->rowCount - 1) {
            $visibleTrees++;
            if ($height <= $this->forrest[$currentRow][$column]) {
                break;
            }
            $currentRow++;
        }

        return $visibleTrees;
    }

    private function lookLeft(int $row, int $column, int $height): int
    {
        $visibleTrees = 0;
        $currentColumn = $column - 1;

        while ($currentColumn >= 0) {
            $visibleTrees++;
            if ($height <= $this->forrest[$row][$currentColumn]) {
                break;
            }
            $currentColumn--;
        }

        return $visibleTrees;
    }

    private function lookRight(int $row, int $column, int $height): int
    {
        $visibleTrees = 0;
        $currentColumn = $column + 1;

        while ($currentColumn <= $this->columnCount - 1) {
            $visibleTrees++;
            if ($height <= $this->forrest[$row][$currentColumn]) {
                break;
            }
            $currentColumn++;
        }

        return $visibleTrees;
    }

    private function isEdgePosition(int $row, int $column): bool
    {
        return 0 === $row
            || $this->rowCount - 1 === $row
            || 0 === $column
            || $this->columnCount - 1 === $column;
    }
}