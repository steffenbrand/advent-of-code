<?php

declare(strict_types=1);

namespace AoC\Year2022\Day14;

class Part1
{
    private const DIRECTION_UP = 'U';
    private const DIRECTION_DOWN = 'D';
    private const DIRECTION_LEFT = 'L';
    private const DIRECTION_RIGHT = 'R';

    private int $maxHorizontal = 0;
    private int $minHorizontal = PHP_INT_MAX;
    private int $maxVertical = 0;

    private array $blocked = [];

    public function solve(string $puzzle): int
    {
        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $edgePositions = explode(' -> ', $line);
            $edges = $this->getEdges($edgePositions);
            $this->markPathBetweenEdgesBlocked($edges);
        }

        $sum = $this->flowSandUntilItFallsIntoTheAbyss();

        return $sum;
    }

    private function getEdges(array $edgePositions): array
    {
        $edges = [];

        foreach ($edgePositions as $edge) {
            $horizontal = (int) explode(',', $edge)[0];
            $vertical = (int) explode(',', $edge)[1];

            if ($horizontal > $this->maxHorizontal) {
                $this->maxHorizontal = $horizontal;
            }
            if ($horizontal < $this->minHorizontal) {
                $this->minHorizontal = $horizontal;
            }
            if ($vertical > $this->maxVertical) {
                $this->maxVertical = $vertical;
            }

            $edges[] = [
                'horizontal' => $horizontal,
                'vertical' => $vertical
            ];
        }

        return $edges;
    }

    private function determineDirection(
        int $currentEdgeHorizontal,
        int $currentEdgeVertical,
        int $nextEdgeHorizontal,
        int $nextEdgeVertical
    ) :string
    {
        if ($nextEdgeHorizontal > $currentEdgeHorizontal) {
            return self::DIRECTION_RIGHT;
        }

        if ($nextEdgeHorizontal < $currentEdgeHorizontal) {
            return self::DIRECTION_LEFT;
        }

        if ($nextEdgeVertical > $currentEdgeVertical) {
            return self::DIRECTION_DOWN;
        }

        return self::DIRECTION_UP;
    }

    private function markPathBetweenEdgesBlocked(array $edges): void
    {
        foreach ($edges as $key => $edge) {
            $nextEdgeKey = $key + 1;

            if (!array_key_exists($nextEdgeKey, $edges)) {
                break;
            }

            $currentEdgeHorizontal = $edge['horizontal'];
            $currentEdgeVertical = $edge['vertical'];
            $nextEdgeHorizontal = $edges[$nextEdgeKey]['horizontal'];
            $nextEdgeVertical = $edges[$nextEdgeKey]['vertical'];

            $direction = $this->determineDirection(
                $currentEdgeHorizontal,
                $currentEdgeVertical,
                $nextEdgeHorizontal,
                $nextEdgeVertical
            );

            if (self::DIRECTION_RIGHT === $direction) {
                while ($nextEdgeHorizontal >= $currentEdgeHorizontal) {
                    $this->markBlocked($currentEdgeHorizontal, $currentEdgeVertical);
                    $currentEdgeHorizontal++;
                }
                continue;
            }

            if (self::DIRECTION_LEFT === $direction) {
                while ($nextEdgeHorizontal <= $currentEdgeHorizontal) {
                    $this->markBlocked($currentEdgeHorizontal, $currentEdgeVertical);
                    $currentEdgeHorizontal--;
                }
                continue;
            }

            if (self::DIRECTION_DOWN === $direction) {
                while ($nextEdgeVertical >= $currentEdgeVertical) {
                    $this->markBlocked($currentEdgeHorizontal, $currentEdgeVertical);
                    $currentEdgeVertical++;
                }
                continue;
            }

            while ($nextEdgeVertical <= $currentEdgeVertical) {
                $this->markBlocked($currentEdgeHorizontal, $currentEdgeVertical);
                $currentEdgeVertical--;
            }
        }
    }

    private function flowSandUntilItFallsIntoTheAbyss(): int
    {
        $sum = 0;

        while (true) {
            $horizontal = 500;
            $vertical = 0;

            while (true) {
                if (!($this->blocked[$horizontal][$vertical + 1] ?? false)) {
                    $vertical++;

                    if ($this->isOutOfBounds($horizontal, $vertical)) {
                        break 2;
                    }

                    continue;
                }

                if (!($this->blocked[$horizontal - 1][$vertical + 1] ?? false)) {
                    $horizontal--;
                    $vertical++;

                    if ($this->isOutOfBounds($horizontal, $vertical)) {
                        break 2;
                    }

                    continue;
                }

                if (!($this->blocked[$horizontal + 1][$vertical + 1] ?? false)) {
                    $horizontal++;
                    $vertical++;

                    if ($this->isOutOfBounds($horizontal, $vertical)) {
                        break 2;
                    }

                    continue;
                }

                $this->markBlocked($horizontal, $vertical);
                $sum++;
                break;
            }
        }

        return $sum;
    }

    private function isOutOfBounds(int $horizontal, int $vertical): bool
    {
        return
            $horizontal > $this->maxHorizontal ||
            $horizontal < $this->minHorizontal ||
            $vertical > $this->maxVertical;
    }

    private function markBlocked(int $horizontal, int $vertical): void
    {
        $this->blocked[$horizontal][$vertical] = true;
    }
}
