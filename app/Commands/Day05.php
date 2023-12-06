<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Str;

class Day05 extends Day
{
    protected $signature = 'day:5';

    protected $description = 'Solutions for Day 5';

    public function handle(): int
    {
        $this->info('Solution 1: '.$this->solutionOne());
        $this->info('Solution 2: '.$this->solutionTwo());

        return parent::SUCCESS;
    }

    public function solutionOne(): int
    {
        $lines = array_filter(explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)));

        $currentKey = 'seeds';
        $data = [];

        $firstLine = array_shift($lines);
        $seeds = explode(' ', Str::after($firstLine, ': '));

        foreach ($lines as $line) {
            $found = preg_match('/([a-z-]+) map:/', $line, $matches);

            if ($found) {
                $currentKey = $matches[1];

                continue;
            }

            $data[$currentKey][] = explode(' ', $line);
        }

        $results = [];

        foreach ($seeds as $seed) {
            $destination = $seed;

            foreach ($data as $maps) {
                foreach ($maps as $map) {
                    $destinationMin = $map[0];
                    [$sourceMin, $sourceMax] = [$map[1], $map[1] + $map[2] - 1];

                    $inRange = $destination >= $sourceMin && $destination <= $sourceMax;

                    if ($inRange) {
                        $diff = $destination - $sourceMin;

                        $destination = $destinationMin + $diff;

                        break;
                    }
                }
            }

            $results[] = $destination;
        }

        return (int) min($results);
    }

    public function solutionTwo(): int
    {
        $lines = array_filter(explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)));

        $currentKey = 'seeds';
        $data = [];

        $firstLine = array_shift($lines);
        $seedRanges = explode(' ', Str::after($firstLine, ': '));
        $seeds = array_chunk($seedRanges, 2);

        foreach ($lines as $line) {
            $found = preg_match('/([a-z-]+) map:/', $line, $matches);

            if ($found) {
                $currentKey = $matches[1];

                continue;
            }

            $data[$currentKey][] = explode(' ', $line);
        }

        $data = array_reverse($data);

        $attempt = 0;
        $answer = null;

        while (is_null($answer)) {
            $carry = $attempt;

            foreach ($data as $maps) {
                foreach ($maps as $map) {
                    [$destinationMin, $destinationMax] = [$map[0], $map[0] + $map[2] - 1];
                    $sourceMin = $map[1];

                    $inRange = $carry >= $destinationMin && $carry <= $destinationMax;

                    if ($inRange) {
                        $diff = $carry - $destinationMin;

                        $carry = $sourceMin + $diff;

                        break;
                    }
                }
            }

            foreach ($seeds as [$seed, $range]) {
                $seedMax = $seed + $range - 1;

                if ($carry >= $seed && $carry <= $seedMax) {
                    $answer = $attempt;

                    break;
                }
            }

            $attempt++;
        }

        return $answer;
    }
}
