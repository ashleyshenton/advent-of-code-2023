<?php

declare(strict_types=1);

use App\Commands\Day06;

it('should return 288 with example input', function () {
    $command = new Day06(
        <<<'INPUT'
        Time:      7  15   30
        Distance:  9  40  200
        INPUT
    );

    $this->assertSame(288, $command->solutionOne());
});

it('should return 71503 with example input', function () {
    $command = new Day06(
        <<<'INPUT'
        Time:      7  15   30
        Distance:  9  40  200
        INPUT
    );

    $this->assertSame(71503, $command->solutionTwo());
});
