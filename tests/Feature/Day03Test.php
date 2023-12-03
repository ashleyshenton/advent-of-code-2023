<?php

declare(strict_types=1);

use App\Commands\Day03;

it('should return 532331 with actual input', function () {
    $command = new Day03();

    $this->assertSame(532331, $command->solutionOne());
});

it('should return 82301120 with actual input', function () {
    $command = new Day03();

    $this->assertSame(82301120, $command->solutionTwo());
});
