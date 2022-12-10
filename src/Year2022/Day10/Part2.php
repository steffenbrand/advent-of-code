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
                $this->increaseHorizontalPosition();
                $instruction->increaseCycleNumber();

                if ($this->horizontalPositionOverlapsWithSpritePosition()) {
                    $this->drawLitPixel();
                } else {
                    $this->drawDarkPixel();
                }

                if ($this->horizontalPositionReachedLineEnd()) {
                    $this->drawNewLine();
                    $this->resetHorizontalPosition();
                }
            }

            $this->updateSpritePosition($instruction->getValue());
        }

        $this->removeLastNewLine();

        return $this->screen;
    }

    private function drawNewLine(): void
    {
        $this->screen .= PHP_EOL;
    }

    private function resetHorizontalPosition(): void
    {
        $this->horizontalPosition = 0;
    }

    private function horizontalPositionReachedLineEnd(): bool
    {
        return $this->horizontalPosition % 40 === 0;
    }

    private function increaseHorizontalPosition(): void
    {
        $this->horizontalPosition++;
    }

    private function updateSpritePosition(int $value): void
    {
        $this->spritePosition += $value;
    }

    private function removeLastNewLine(): void
    {
        $this->screen = rtrim($this->screen);
    }

    private function horizontalPositionOverlapsWithSpritePosition(): bool
    {
        return
            $this->horizontalPosition >= $this->spritePosition &&
            $this->horizontalPosition <= $this->spritePosition + 2;
    }

    private function drawLitPixel(): void
    {
        $this->screen .= '#';
    }

    private function drawDarkPixel(): void
    {
        $this->screen .= '.';
    }
}