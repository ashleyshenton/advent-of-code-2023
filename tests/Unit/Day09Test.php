<?php

declare(strict_types=1);

use App\Commands\Day09;

it('should return 114 with example input', function () {
    $command = new Day09(
        <<<'INPUT'
        0 3 6 9 12 15
        1 3 6 10 15 21
        10 13 16 21 30 45
        INPUT
    );

    $this->assertSame(114, $command->solutionOne());
});

it('should return 2 with example input', function () {
    $command = new Day09(
        <<<'INPUT'
        0 3 6 9 12 15
        1 3 6 10 15 21
        10 13 16 21 30 45
        INPUT
    );

    $this->assertSame(2, $command->solutionTwo());
});
