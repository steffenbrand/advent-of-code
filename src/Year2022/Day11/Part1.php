<?php

declare(strict_types=1);

namespace AoC\Year2022\Day11;

class Part1
{
    /**
     * @var Monkey[]
     */
    private array $monkeys;

    public function solve(string $puzzle): int
    {
        foreach (explode(PHP_EOL.PHP_EOL, $puzzle) as $monkeyString) {
            $this->monkeys[] = Monkey::createFromMonkeyString($monkeyString);
        }

        for ($round = 1; $round <= 20; $round++) {
            foreach ($this->monkeys as $monkey) {
                foreach ($monkey->inspectItems(3, null) as $throw) {
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