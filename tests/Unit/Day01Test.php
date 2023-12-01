<?php

declare(strict_types=1);

use App\Commands\Day01;

it('should return 142 with example input', function () {
    $command = new Day01(
        <<<'INPUT'
        1abc2
        pqr3stu8vwx
        a1b2c3d4e5f
        treb7uchet
        INPUT
    );

    $this->assertSame(142, $command->solutionOne());
});

it('should return 281 with example input', function () {
    $command = new Day01(
        <<<'INPUT'
        two1nine
        eightwothree
        abcone2threexyz
        xtwone3four
        4nineeightseven2
        zoneight234
        7pqrstsixteen
        INPUT
    );

    $this->assertSame(281, $command->solutionTwo());
});
