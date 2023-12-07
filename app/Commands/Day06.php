<?php

declare(strict_types=1);

namespace App\Commands;

class Day06 extends Day
{
    protected $signature = 'day:6';

    protected $description = 'Solutions for Day 6';

    public function solutionOne(): int
    {
        $lines = array_filter(explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)));

        preg_match_all('/\d+/', $lines[0], $matches);
        $times = array_map('intval', $matches[0]);
        preg_match_all('/\d+/', $lines[1], $matches);
        $distances = array_map('intval', $matches[0]);

        $countOfPossibleSolutions = array_fill(0, count($times), 0);

        foreach ($times as $index => $time) {
            $millisecondsHeld = 1;
            $recordToBeat = $distances[$index];

            while ($millisecondsHeld < $time) {
                $timeToTravel = $time - $millisecondsHeld;
                $distanceTravelled = $timeToTravel * $millisecondsHeld;

                if ($distanceTravelled > $recordToBeat) {
                    $countOfPossibleSolutions[$index]++;
                }

                $millisecondsHeld++;
            }
        }

        return array_reduce($countOfPossibleSolutions, fn (int $carry, int $item) => $carry * $item, 1);
    }

    public function solutionTwo(): int
    {
        $lines = array_filter(explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)));

        preg_match_all('/\d+/', $lines[0], $matches);
        $time = intval(array_reduce($matches[0], fn (string $carry, string $item) => $carry.$item, ''));
        preg_match_all('/\d+/', $lines[1], $matches);
        $distance = intval(array_reduce($matches[0], fn (string $carry, string $item) => $carry.$item, ''));

        $countOfPossibleSolutions = 0;

        $millisecondsHeld = 1;

        while ($millisecondsHeld < $time) {
            $timeToTravel = $time - $millisecondsHeld;
            $distanceTravelled = $timeToTravel * $millisecondsHeld;

            if ($distanceTravelled > $distance) {
                $countOfPossibleSolutions++;
            }

            $millisecondsHeld++;
        }

        return $countOfPossibleSolutions;
    }
}
