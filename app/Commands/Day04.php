<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Str;

class Day04 extends Day
{
    public function solutionOne(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        return collect($lines)->mapWithKeys(function (string $line) {
            $key = Str::before($line, ':');

            $cards = collect(explode('|', Str::after($line, ':')))->map(function (string $card) {
                preg_match_all('/\d+/', $card, $matches);

                return $matches[0];
            });

            return [$key => [
                'winning' => $cards[0],
                'yours' => $cards[1],
            ]];
        })->reduce(function (int $carry, array $cards) {
            $matching = array_intersect($cards['winning'], $cards['yours']);
            $count = count($matching);

            if (! $count) {
                return $carry;
            }

            if ($count === 1) {
                return $carry + 1;
            }

            if ($count === 2) {
                return $carry + 2;
            }

            $power = $count - 1;

            return $carry + 2 ** $power;
        }, 0);
    }

    public function solutionTwo(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        $original = collect($lines)->mapWithKeys(function (string $line) {
            preg_match('/Card\s+(\d+):/', $line, $matches);
            $key = (int) $matches[1];

            $cards = collect(explode('|', Str::after($line, ':')))->map(function (string $card) {
                preg_match_all('/\d+/', $card, $matches);

                return $matches[0];
            });

            return [$key => [
                'number' => $key,
                'winning' => $cards[0],
                'yours' => $cards[1],
            ]];
        })->all();

        $cards = array_map(function (string $line) {
            preg_match('/Card\s+(\d+):/', $line, $matches);
            $key = (int) $matches[1];

            $cards = collect(explode('|', Str::after($line, ':')))->map(function (string $card) {
                preg_match_all('/\d+/', $card, $matches);

                return $matches[0];
            });

            return [
                'number' => $key,
                'winning' => $cards[0],
                'yours' => $cards[1],
            ];
        }, $lines);

        $currentIndex = 0;

        while (isset($cards[$currentIndex])) {
            $card = $cards[$currentIndex];

            $matching = array_intersect($card['winning'], $card['yours']);
            $count = count($matching);

            if (! $count) {
                $currentIndex++;

                continue;
            }

            foreach (range(1, $count) as $increment) {
                $cards[] = $original[$card['number'] + $increment];
            }

            $currentIndex++;
        }

        return count($cards);
    }
}
