<?php

declare(strict_types=1);

namespace App\Commands;

class Day01 extends Day
{
    protected $signature = 'day:1';

    protected $description = 'Solutions for Day 1';

    public function solutionOne(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        return array_reduce($lines, function (int $carry, string $line) {
            preg_match('/\d/', $line, $matches);

            $firstDigit = $matches[0];

            preg_match('/\d/', strrev($line), $matches);

            $lastDigit = $matches[0];

            $number = (int) ($firstDigit.$lastDigit);

            return $carry + $number;
        }, 0);
    }

    public function solutionTwo(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        return array_reduce($lines, function (int $carry, string $line) {
            preg_match('/\d|one|two|three|four|five|six|seven|eight|nine/', $line, $matches);

            $firstDigit = $matches[0];

            if (! is_numeric($firstDigit)) {
                $firstDigit = match ($firstDigit) {
                    'one' => '1',
                    'two' => '2',
                    'three' => '3',
                    'four' => '4',
                    'five' => '5',
                    'six' => '6',
                    'seven' => '7',
                    'eight' => '8',
                    'nine' => '9',
                };
            }

            preg_match('/.*(\d|one|two|three|four|five|six|seven|eight|nine)/', $line, $matches);

            $lastDigit = $matches[1];

            if (! is_numeric($lastDigit)) {
                $lastDigit = match ($lastDigit) {
                    'one' => '1',
                    'two' => '2',
                    'three' => '3',
                    'four' => '4',
                    'five' => '5',
                    'six' => '6',
                    'seven' => '7',
                    'eight' => '8',
                    'nine' => '9',
                };
            }

            $number = (int) ($firstDigit.$lastDigit);

            return $carry + $number;
        }, 0);
    }
}
