<?php

declare(strict_types=1);

namespace AoC\Year2022\Day5;

class Part1
{
    private const NO_CRATE = ' ';

    public function solve(string $puzzle): string
    {
        [$stackSchema, $movementSchema] = explode(PHP_EOL.PHP_EOL, $puzzle);

        $numberOfStacks = $this->getNumberOfStacks($stackSchema);
        $cratePositions = $this->getCratePositions($numberOfStacks);
        $cargo = $this->getInitialCargo($stackSchema, $numberOfStacks, $cratePositions);
        $movements = $this->getMovements($movementSchema);
        $cargo = $this->applyMovements($cargo, $movements);
        $code = $this->getCode($cargo);

        return $code;
    }

    private function getNumberOfStacks(string $stackSchema): int
    {
        return (int) $stackSchema[strlen($stackSchema) - 2];
    }

    private function getCratePositions(int $numberOfStacks): array
    {
        $cratePositions = [];

        for ($s = 1; $s <= $numberOfStacks; $s++) {
            $cratePositions[$s] = $s === 1 ? 1 : $cratePositions[$s - 1] + 4;
        }

        return $cratePositions;
    }

    private function getInitialCargo(
        string $stackSchema,
        int $numberOfStacks,
        array $cratePositions
    ): array {
        $cargo = [];

        $stacks = substr($stackSchema, 0, strrpos($stackSchema, PHP_EOL));

        foreach (explode(PHP_EOL, $stacks) as $line) {
            for ($s = 1; $s <= $numberOfStacks; $s++) {
                $crate = $line[$cratePositions[$s]];
                if (self::NO_CRATE === $crate) {
                    continue;
                }
                $cargo[$s][] = $crate;
            }
        }

        ksort($cargo);

        return $cargo;
    }

    private function getMovements(string $movementSchema): array
    {
        $movements = [];

        foreach (explode(PHP_EOL, $movementSchema) as $line) {
            preg_match_all('!\d+!', $line, $matches);
            $movements[] = $matches[0];
        }

        return $movements;
    }

    private function applyMovements(array $cargo, array $movements): array
    {
        foreach ($movements as $movement) {
            for ($i = 1; $i <= $movement[0]; $i++) {
                $crate = array_shift($cargo[$movement[1]]);
                array_unshift($cargo[$movement[2]], $crate);
            }
        }

        return $cargo;
    }

    private function getCode(array $cargo): string
    {
        $code = '';

        foreach ($cargo as $stack) {
            $code .= array_shift($stack);
        }

        return $code;
    }
}