<?php

declare(strict_types=1);

namespace App\Commands;

class Day03 extends Day
{
    protected $signature = 'day:3';

    protected $description = 'Solutions for Day 3';

    public function handle(): int
    {
        $this->info('Solution 1: '.$this->solutionOne());
        $this->info('Solution 2: '.$this->solutionTwo());

        return parent::SUCCESS;
    }

    public function solutionOne(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        return collect($lines)
            ->reduce(function (int $carry, string $line, int $index) use ($lines) {
                preg_match_all('/\d+/', $line, $matches, PREG_OFFSET_CAPTURE);

                $lineTotal = 0;

                foreach ($matches[0] as [$number, $position]) {
                    $numberLength = strlen($number);
                    $offset = max($position - 1, 0);
                    $length = $numberLength + ($position - 1 < 0 ? 1 : 2);

                    if (isset($lines[$index - 1])) {
                        $partsAbove = substr($lines[$index - 1], $offset, $length);

                        if (preg_match('/[^.\d]/', $partsAbove)) {
                            $lineTotal += (int) $number;

                            continue;
                        }
                    }

                    $sameLine = substr($line, $offset, $length);

                    if (preg_match('/[^.\d]/', $sameLine)) {
                        $lineTotal += (int) $number;

                        continue;
                    }

                    if (isset($lines[$index + 1])) {
                        $partsBelow = substr($lines[$index + 1], $offset, $length);

                        if (preg_match('/[^.\d]/', $partsBelow)) {
                            $lineTotal += (int) $number;
                        }
                    }
                }

                return $carry + $lineTotal;
            }, 0);
    }

    public function solutionTwo(): int
    {
        $lines = explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL));

        return collect($lines)
            ->reduce(function (int $carry, string $line, int $index) use ($lines) {
                $count = preg_match_all('/\*/', $line, $matches, PREG_OFFSET_CAPTURE);

                if (! $count) {
                    return $carry;
                }

                $asteriskPositions = array_map(fn (array $match) => $match[1], $matches[0]);

                $totalForRow = 0;

                foreach ($asteriskPositions as $position) {
                    $calculatedNumber = $this->findCalculatedNumber($lines, $index, $position);

                    $totalForRow += $calculatedNumber;
                }

                return $carry + $totalForRow;
            }, 0);
    }

    protected function findCalculatedNumber(array $lines, int $row, int $asterisk): int
    {
        $numbers = [];

        if (isset($lines[$row - 1])) {
            $numbers = $this->findOnAdjacentRow($lines[$row - 1], $asterisk);
        }

        $numbers = [...$numbers, ...$this->findOnSameRow($lines[$row], $asterisk)];

        if (isset($lines[$row + 1])) {
            $numbers = [...$numbers, ...$this->findOnAdjacentRow($lines[$row + 1], $asterisk)];
        }

        return count($numbers) === 2
            ? $numbers[0] * $numbers[1]
            : 0;
    }

    protected function findOnSameRow(string $row, int $asterisk): array
    {
        $rowChars = str_split($row);

        $left = $asterisk === 0 ? null : $rowChars[$asterisk - 1];
        $right = $asterisk === count($rowChars) - 1 ? null : $rowChars[$asterisk + 1];

        $first = '';

        if (is_numeric($left)) {
            $first = $left;

            if (is_numeric($rowChars[$asterisk - 2])) {
                $first = $rowChars[$asterisk - 2].$first;

                if (is_numeric($rowChars[$asterisk - 3])) {
                    $first = $rowChars[$asterisk - 3].$first;
                }
            }
        }

        $second = '';

        if (is_numeric($right)) {
            $second = $right;

            if (is_numeric($rowChars[$asterisk + 2])) {
                $second .= $rowChars[$asterisk + 2];

                if (is_numeric($rowChars[$asterisk + 3])) {
                    $second .= $rowChars[$asterisk + 3];
                }
            }
        }

        return array_filter([$first, $second], fn (string $number) => $number !== '');
    }

    protected function findOnAdjacentRow(string $row, int $asterisk): array
    {
        $rowChars = str_split($row);

        $middle = $rowChars[$asterisk];

        if (is_numeric($middle)) {
            $first = $middle;

            if (is_numeric($rowChars[$asterisk - 1])) {
                $first = $rowChars[$asterisk - 1].$first;

                if (is_numeric($rowChars[$asterisk - 2])) {
                    $first = $rowChars[$asterisk - 2].$first;
                }
            }

            if (is_numeric($rowChars[$asterisk + 1])) {
                $first .= $rowChars[$asterisk + 1];

                if (is_numeric($rowChars[$asterisk + 2])) {
                    $first .= $rowChars[$asterisk + 2];
                }
            }

            return [$first];
        }

        return $this->findOnSameRow($row, $asterisk);
    }
}
