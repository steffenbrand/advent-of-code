<?php

declare(strict_types=1);

namespace AoC\Year2022\Day10;

class Part2
{
    private int $spritePosition = 1;
    private int $horizontalPosition = 0;
    private string $screen = '';

    public function solve(string $puzzle): string
    {
        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $instruction = Instruction::createFromLine($line);

            while ($instruction->inExecution()) {
                $this->horizontalPosition++;
                $instruction->increaseCycleNumber();
                $this->drawPixel();

                if ($this->horizontalPosition % 40 === 0) {
                    $this->DrawNewLine();
                    $this->horizontalPosition = 0;
                }
            }

            $this->spritePosition += $instruction->getValue();
        }

        return rtrim($this->screen);
    }

    private function drawPixel(): void
    {
        if ($this->horizontalPosition >= $this->spritePosition &&
            $this->horizontalPosition <= $this->spritePosition + 2)
        {
            $this->screen .= '#';
            return;
        }

        $this->screen .= '.';
    }

    private function DrawNewLine(): void
    {
        $this->screen .= PHP_EOL;
    }
}