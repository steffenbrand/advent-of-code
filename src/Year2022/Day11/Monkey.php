<?php

declare(strict_types=1);

namespace AoC\Year2022\Day11;

class Monkey
{
    private array $items;
    private string $operation;
    private int $divisibleBy;
    private int $targetTrue;
    private int $targetFalse;
    private int $inspections = 0;

    private function __construct(
        array $items,
        string $operation,
        int $divisibleBy,
        int $targetTrue,
        int $targetFalse
    ) {
        $this->items = $items;
        $this->operation = $operation;
        $this->divisibleBy = $divisibleBy;
        $this->targetTrue = $targetTrue;
        $this->targetFalse = $targetFalse;
    }

    public static function createFromMonkeyString(string $monkeyString): self
    {
        $lines = explode(PHP_EOL, $monkeyString);

        $items = array_map('intval', explode(', ', explode('Starting items: ', $lines[1])[1]));
        $operation = explode('Operation: new = old ', $lines[2])[1];
        $divisibleBy = (int) explode('Test: divisible by ', $lines[3])[1];
        $targetTrue = (int) explode('If true: throw to monkey ', $lines[4])[1];
        $targetFalse = (int) explode('If false: throw to monkey ', $lines[5])[1];

        return new self(
            $items,
            $operation,
            $divisibleBy,
            $targetTrue,
            $targetFalse
        );
    }

    public function inspectItems(?int $divideBy, ?int $divisorProduct): array
    {
        $throws = [];

        while ($worryLevel = array_shift($this->items)) {
            $this->inspections++;

            $worryLevel = (int) eval('return ' . $worryLevel . ($this->operation === '* old' ? '* ' . $worryLevel : $this->operation) . ';');

            if ($divideBy) {
                $worryLevel = (int) round($worryLevel/$divideBy, 5);
            }

            if ($divisorProduct) {
                $worryLevel %= $divisorProduct;
            }

            if ($worryLevel % $this->divisibleBy === 0) {
                $throws[] = [$this->targetTrue, $worryLevel];
                continue;
            }

            $throws[] = [$this->targetFalse, $worryLevel];
        }

        return $throws;
    }

    public function catchItem(int $item): void
    {
        $this->items[] = $item;
    }

    public function getInspections(): int
    {
        return $this->inspections;
    }

    public function getDivisibleBy(): int
    {
        return $this->divisibleBy;
    }
}