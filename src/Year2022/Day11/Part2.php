<?php

declare(strict_types=1);

namespace AoC\Year2022\Day11;

class Part2
{
    /**
     * @var Monkey[]
     */
    private array $monkeys;

    public function solve(string $puzzle): int
    {
        $divisorProduct = 0;

        foreach (explode(PHP_EOL.PHP_EOL, $puzzle) as $monkeyString) {
            $this->monkeys[] = $monkey = Monkey::createFromMonkeyString($monkeyString);
            $divisorProduct = $divisorProduct > 0
                ? $divisorProduct * $monkey->getDivisibleBy()
                : $monkey->getDivisibleBy();
        }

        for ($round = 1; $round <= 10000; $round++) {
            foreach ($this->monkeys as $monkey) {
                foreach ($monkey->inspectItems(null, $divisorProduct) as $throw) {
                    $this->monkeys[$throw[0]]->catchItem($throw[1]);
                }
            }
        }

        $inspections = [];
        foreach ($this->monkeys as $key => $monkey) {
            $inspections[$key] = $monkey->getInspections();
        }
        rsort($inspections);

        return $inspections[0] * $inspections[1];
    }
}