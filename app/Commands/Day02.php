<?php

declare(strict_types=1);

namespace App\Commands;

class Day02 extends Day
{
    protected $signature = 'day:2';

    protected $description = 'Solutions for Day 2';

    public function handle(): int
    {
        $this->info('Solution 1: '.$this->solutionOne());
        $this->info('Solution 2: '.$this->solutionTwo());

        return parent::SUCCESS;
    }

    public function solutionOne(): int
    {
        return collect(explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)))
            ->mapWithKeys(function (string $line) {
                $biggestCounts = collect(explode(';', str()->after($line, ': ')))->map(function ($colours) {
                    preg_match_all('/(\d+) (red|blue|green)/', $colours, $matches);

                    $results = [
                        'red' => 0,
                        'blue' => 0,
                        'green' => 0,
                    ];

                    foreach ($matches[2] as $index => $colour) {
                        $results[$colour] = (int) $matches[1][$index];
                    }

                    return $results;
                })
                    ->reduce(function ($carry, $colours) {
                        foreach ($colours as $colour => $count) {
                            if (($carry[$colour] ?? -1) < $count) {
                                $carry[$colour] = $count;
                            }
                        }

                        return $carry;
                    }, []);

                return [
                    str($line)->before(':')->after('Game ')->value() => $biggestCounts
                ];
            })->reduce(function ($carry, $game, $id) {
                // only 12 red cubes, 13 green cubes, and 14 blue cubes?
                if ($game['red'] > 12) {
                    return $carry;
                }

                if ($game['green'] > 13) {
                    return $carry;
                }

                if ($game['blue'] > 14) {
                    return $carry;
                }

                return $carry + $id;
            }, 0);
    }

    public function solutionTwo(): int
    {
        return collect(explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)))
            ->map(function (string $line) {
                return collect(explode(';', str()->after($line, ': ')))->map(function ($colours) {
                    preg_match_all('/(\d+) (red|blue|green)/', $colours, $matches);

                    $results = [
                        'red' => 0,
                        'blue' => 0,
                        'green' => 0,
                    ];

                    foreach ($matches[2] as $index => $colour) {
                        $results[$colour] = (int) $matches[1][$index];
                    }

                    return $results;
                })
                    ->reduce(function ($carry, $colours) {
                        foreach ($colours as $colour => $count) {
                            if (($carry[$colour] ?? -1) < $count) {
                                $carry[$colour] = $count;
                            }
                        }

                        return $carry;
                    }, []);
            })->reduce(fn ($carry, $game) => $carry + $game['red'] * $game['green'] * $game['blue'], 0);
    }
}
