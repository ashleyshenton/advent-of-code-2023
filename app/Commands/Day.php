<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

abstract class Day extends Command
{
    protected $signature = 'day:%d
                            {--part= : Which part of the puzzle to run (1 or 2)}';

    protected $description = 'Solutions for Day %d';

    public function __construct(protected ?string $puzzleInput = null)
    {
        $day = intval(Str::after($this::class, 'Day'));

        $this->signature = sprintf($this->signature, $day);
        $this->description = sprintf($this->description, $day);

        parent::__construct();

        $this->puzzleInput ??= Cache::rememberForever("day:$day", fn () => Http::aocDay($day));
    }

    public function handle(): int
    {
        $part = $this->option('part');

        if ($part && ! in_array($part, ['1', '2'], true)) {
            $this->error('Part must be 1 or 2');

            return parent::FAILURE;
        }

        if (! $part || $part === '1') {
            $this->info('Solution 1: '.$this->solutionOne());
        }

        if (! $part || $part === '2') {
            $this->info('Solution 2: ' . $this->solutionTwo());
        }

        return parent::SUCCESS;
    }

    abstract public function solutionOne(): int;

    abstract public function solutionTwo(): int;
}
