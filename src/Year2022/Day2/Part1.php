<?php

declare(strict_types=1);

namespace AoC\Year2022\Day2;

class Part1
{
    private const OP_ROCK = 'A';
    private const OP_PAPER = 'B';
    private const OP_SCISSORS = 'C';

    private const ME_ROCK = 'X';
    private const ME_PAPER = 'Y';
    private const ME_SCISSORS = 'Z';

    private const WON = 'won';
    private const DRAW = 'draw';
    private const LOST = 'lost';

    private const VALUES = [
        self::ME_ROCK => 1,
        self::ME_PAPER => 2,
        self::ME_SCISSORS => 3,
        self::WON => 6,
        self::DRAW => 3,
        self::LOST => 0,
    ];

    private const OUTCOMES = [
        self::OP_ROCK .         self::ME_ROCK       => self::VALUES[self::DRAW] + self::VALUES[self::ME_ROCK],
        self::OP_ROCK .         self::ME_PAPER      => self::VALUES[self::WON]  + self::VALUES[self::ME_PAPER],
        self::OP_ROCK .         self::ME_SCISSORS   => self::VALUES[self::LOST] + self::VALUES[self::ME_SCISSORS],
        self::OP_PAPER .        self::ME_ROCK       => self::VALUES[self::LOST] + self::VALUES[self::ME_ROCK],
        self::OP_PAPER .        self::ME_PAPER      => self::VALUES[self::DRAW] + self::VALUES[self::ME_PAPER],
        self::OP_PAPER .        self::ME_SCISSORS   => self::VALUES[self::WON]  + self::VALUES[self::ME_SCISSORS],
        self::OP_SCISSORS .     self::ME_ROCK       => self::VALUES[self::WON]  + self::VALUES[self::ME_ROCK],
        self::OP_SCISSORS .     self::ME_PAPER      => self::VALUES[self::LOST] + self::VALUES[self::ME_PAPER],
        self::OP_SCISSORS .     self::ME_SCISSORS   => self::VALUES[self::DRAW] + self::VALUES[self::ME_SCISSORS],
    ];

    public function solve(string $puzzle): int
    {
        $sum = 0;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $sum += self::OUTCOMES[str_replace(' ', '', $line)];
        }

        return $sum;
    }
}