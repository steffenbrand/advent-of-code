<?php

declare(strict_types=1);

namespace AoC\Year2022\Day12;
use Fhaculty\Graph\Exception\OutOfBoundsException;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\ShortestPath\BreadthFirst;

class Part2
{
    private const START_INDICATOR = 'S';
    private const LOWEST_LEVEL_INDICATOR = 'a';
    private const END_INDICATOR = 'E';

    private array $charToHeightMap;
    private array $startPositionNames = [];
    private string $endPositionName = '';

    public function __construct() {
        $this->charToHeightMap = $this->createCharToHeightMap();
    }

    public function solve(string $puzzle): int
    {
        $matrix = $this->createMatrix($puzzle);
        [$startPositions, $end] = $this->createGraph($matrix);
        $fewestSteps = $this->getPathWithFewestSteps($startPositions, $end);

        return $fewestSteps;
    }

    private function createMatrix(string $puzzle): array
    {
        $graph = [];

        foreach (explode(PHP_EOL, $puzzle) as $row => $columns) {
            foreach (str_split($columns) as $column => $char) {
                if (self::START_INDICATOR === $char || self::LOWEST_LEVEL_INDICATOR === $char) {
                    $this->startPositionNames[] = $this->getPositionName($row, $column);
                }

                if (self::END_INDICATOR === $char) {
                    $this->endPositionName = $this->getPositionName($row, $column);
                }

                $graph[$row][$column] = $this->charToHeightMap[$char];
            }
        }

        return $graph;
    }

    private function createGraph(array $matrix): array
    {
        $graph = new Graph();

        foreach ($matrix as $currentRow => $columns) {
            foreach ($columns as $currentColumn => $height) {
                $currentName = $this->getPositionName($currentRow, $currentColumn);
                try {
                    $currentVertex = $graph->getVertex($currentName);
                } catch (OutOfBoundsException) {
                    $currentVertex = $graph->createVertex($currentName);
                }

                foreach ([[-1, 0],[1, 0],[0, -1],[0, 1]] as $direction) {
                    $targetRow = $currentRow + $direction[0];
                    $targetColumn = $currentColumn + $direction[1];

                    if ($this->isReachable($currentRow, $currentColumn, $targetRow, $targetColumn, $matrix)) {
                        $targetName = $this->getPositionName($targetRow, $targetColumn);

                        try {
                            $targetVertex = $graph->getVertex($targetName);
                        } catch (OutOfBoundsException) {
                            $targetVertex = $graph->createVertex($targetName);
                        }

                        $currentVertex->createEdgeTo($targetVertex);
                    }
                }

            }
        }

        $startPositions = [];
        foreach ($this->startPositionNames as $startPositionName) {
            $startPositions[] = $graph->getVertex($startPositionName);
        }

        $end = $graph->getVertex($this->endPositionName);

        return [$startPositions, $end];
    }

    private function isReachable(int $currentRow, int $currentColumn, int $targetRow, int $targetColumn, array $matrix): bool
    {
        $currentHeight = $matrix[$currentRow][$currentColumn];

        if ($this->targetIsInsideMatrix($targetRow, $matrix, $targetColumn)) {
            $targetHeight = $matrix[$targetRow][$targetColumn];
            if ($currentHeight > $targetHeight ||
                $currentHeight === $targetHeight ||
                $currentHeight + 1 === $targetHeight)
            {
                return true;
            }
        }

        return false;
    }

    private function targetIsInsideMatrix(int $targetRow, array $matrix, int $targetColumn): bool
    {
        return array_key_exists($targetRow, $matrix) && array_key_exists($targetColumn, $matrix[$targetRow]);
    }

    private function getPositionName(int $row, int $column): string
    {
        return sprintf('%d-%d', $row, $column);
    }

    /**
     * @param Vertex[] $startPositions
     */
    private function getPathWithFewestSteps(array $startPositions, Vertex $end): int
    {
        $fewestSteps = PHP_INT_MAX;

        foreach ($startPositions as $startPositionVertex) {
            try {
                $walk = (new BreadthFirst($startPositionVertex))->getWalkTo($end);
            } catch (OutOfBoundsException) {
                continue;
            }
            if ($walk->getEdges()->count() < $fewestSteps) {
                $fewestSteps = $walk->getEdges()->count();
            }
        }

        return $fewestSteps;
    }

    private function createCharToHeightMap(): array
    {
        $charToVertMap = [
            'S' => 1,
            'E' => 26
        ];

        $i = 1;
        foreach (range('a', 'z') as $char) {
            $charToVertMap[$char] = $i;
            $i++;
        }

        return $charToVertMap;
    }
}