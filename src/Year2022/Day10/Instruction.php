<?php

declare(strict_types=1);

namespace AoC\Year2022\Day10;

class Instruction
{
    public const INSTRUCTION_ADDX = 'addx';

    private int $value;
    private int $cyclesToComplete;
    private int $currentCycle = 0;

    private function __construct(int $value, int $cyclesToComplete)
    {
        $this->value = $value;
        $this->cyclesToComplete = $cyclesToComplete;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function increaseCycleNumber(): void
    {
        $this->currentCycle++;
    }

    public function inExecution(): bool
    {
        return $this->cyclesToComplete > $this->currentCycle;
    }

    public static function createFromLine(string $line): self
    {
        $operation = explode(' ', $line);

        $instruction = $operation[0];
        $value = array_key_exists(1, $operation) ? (int) $operation[1] : 0;
        $cyclesToComplete = self::INSTRUCTION_ADDX === $instruction ? 2 : 1;

        return new self($value, $cyclesToComplete);
    }
}