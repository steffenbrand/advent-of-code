<?php

declare(strict_types=1);

namespace AoC\Year2022\Day2;

class Part2
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

    private const TARGETS = [
        'X' => self::LOST,
        'Y' => self::DRAW,
        'Z' => self::WON,
    ];

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

    private const RESPONSES = [
        self::OP_ROCK .     self::WON   => self::ME_PAPER,
        self::OP_ROCK .     self::DRAW  => self::ME_ROCK,
        self::OP_ROCK .     self::LOST  => self::ME_SCISSORS,
        self::OP_PAPER .    self::WON   => self::ME_SCISSORS,
        self::OP_PAPER .    self::DRAW  => self::ME_PAPER,
        self::OP_PAPER .    self::LOST  => self::ME_ROCK,
        self::OP_SCISSORS . self::WON   => self::ME_ROCK,
        self::OP_SCISSORS . self::DRAW  => self::ME_SCISSORS,
        self::OP_SCISSORS . self::LOST  => self::ME_PAPER,
    ];

    public function solve(string $puzzle): int
    {
        $sum = 0;

        foreach (explode(PHP_EOL, $puzzle) as $line) {
            $opponent = substr(str_replace(' ', '', $line), 0, 1);
            $target = substr(str_replace(' ', '', $line), 1, 1);
            $response = self::RESPONSES[$opponent . self::TARGETS[$target]];
            $play = $opponent . $response;

            $sum += self::OUTCOMES[$play];
        }

        return $sum;
    }
}