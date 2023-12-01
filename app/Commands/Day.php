<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

abstract class Day extends Command
{
    public function __construct(protected ?string $puzzleInput = null)
    {
        parent::__construct();

        $day = (int) Str::after($this->signature, 'day:');

        $this->puzzleInput ??= Cache::rememberForever("day:$day", fn () => Http::aocDay($day));
    }
}
