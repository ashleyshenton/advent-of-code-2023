<?php

declare(strict_types=1);

namespace App\Commands;

class Day08 extends Day
{
    public function solutionOne(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        $instructions = str_split(array_shift($lines));
        unset($lines[0]);

        $lines = collect($lines)->mapWithKeys(function (string $line) {
            preg_match('/([A-Z]{3}) = \(([A-Z]{3}), ([A-Z]{3})\)/', $line, $matches);

            return [$matches[1] => [$matches[2], $matches[3]]];
        })->all();

        $currentPosition = 'AAA';
        $currentDirectionIndex = 0;
        $movesMade = 0;

        while ($currentPosition !== 'ZZZ') {
            if (! isset($instructions[$currentDirectionIndex])) {
                $currentDirectionIndex = 0;
            }

            $direction = $instructions[$currentDirectionIndex] === 'L' ? 0 : 1;

            $currentPosition = $lines[$currentPosition][$direction];
            $currentDirectionIndex++;
            $movesMade++;
        }

        return $movesMade;
    }

    public function solutionTwo(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        $instructions = str_split(array_shift($lines));
        unset($lines[0]);

        $lines = collect($lines)->mapWithKeys(function (string $line) {
            preg_match('/([A-Z\d]{3}) = \(([A-Z\d]{3}), ([A-Z\d]{3})\)/', $line, $matches);

            return [$matches[1] => [$matches[2], $matches[3]]];
        });

        $currentPositions = $lines->keys()->filter(fn ($key) => str_ends_with($key, 'A'));
        $stepsTaken = [];

        foreach ($currentPositions as $currentPosition) {
            $currentDirectionIndex = 0;
            $movesMade = 0;

            while (! str_ends_with($currentPosition, 'Z')) {
                if (! isset($instructions[$currentDirectionIndex])) {
                    $currentDirectionIndex = 0;
                }

                $direction = $instructions[$currentDirectionIndex] === 'L' ? 0 : 1;

                $currentPosition = $lines[$currentPosition][$direction];

                $currentDirectionIndex++;
                $movesMade++;
            }

            $stepsTaken[] = $movesMade;
        }

        $lcm = array_shift($stepsTaken);
        foreach ($stepsTaken as $step) {
            $lcm = gmp_lcm($lcm, $step);
        }

        return gmp_intval($lcm);
    }
}
