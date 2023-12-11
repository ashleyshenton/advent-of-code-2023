<?php

declare(strict_types=1);

namespace App\Commands;

class Day09 extends Day
{
    public function solutionOne(): int
    {
        $lines = array_map(
            fn (string $line) => array_map('intval', explode(' ', $line)),
            explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL))
        );

        $lastDigits = [];

        foreach ($lines as $numbers) {
            $resultIndex = 1;
            $index = 0;
            $rows = [$numbers];

            while ((array_count_values(end($rows))[0] ?? 0) !== (count($rows[max(count($rows) - 2, 0)]) - 1)) {
                if (! isset($rows[$resultIndex - 1][$index + 1])) {
                    $resultIndex++;
                    $rows[$resultIndex] = [];
                    $index = 0;

                    continue;
                }

                $rows[$resultIndex][] = $rows[$resultIndex - 1][$index + 1] - $rows[$resultIndex - 1][$index];
                $index++;
            }

            $lastDigits[] = array_reduce(array_reverse($rows), fn (int $carry, array $row) => $carry + end($row), 0);
        }

        return array_sum($lastDigits);
    }

    public function solutionTwo(): int
    {
        $lines = array_map(
            fn (string $line) => array_map('intval', explode(' ', $line)),
            explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL))
        );

        $firstDigits = [];

        foreach ($lines as $numbers) {
            $resultIndex = 1;
            $index = 0;
            $rows = [$numbers];

            while ((array_count_values(end($rows))[0] ?? 0) !== (count($rows[max(count($rows) - 2, 0)]) - 1)) {
                if (! isset($rows[$resultIndex - 1][$index + 1])) {
                    $resultIndex++;
                    $rows[$resultIndex] = [];
                    $index = 0;

                    continue;
                }

                $rows[$resultIndex][] = $rows[$resultIndex - 1][$index + 1] - $rows[$resultIndex - 1][$index];
                $index++;
            }

            $firstDigits[] = array_reduce(array_reverse($rows), fn (int $carry, array $row) => $row[0] - $carry, 0);
        }

        return array_sum($firstDigits);
    }
}
