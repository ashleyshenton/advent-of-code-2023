<?php

declare(strict_types=1);

use App\Commands\Day08;

it('should return 2 with example input', function () {
    $command = new Day08(
        <<<'INPUT'
        RL

        AAA = (BBB, CCC)
        BBB = (DDD, EEE)
        CCC = (ZZZ, GGG)
        DDD = (DDD, DDD)
        EEE = (EEE, EEE)
        GGG = (GGG, GGG)
        ZZZ = (ZZZ, ZZZ)
        INPUT
    );

    $this->assertSame(2, $command->solutionOne());
});

it('should return 6 with example input', function () {
    $command = new Day08(
        <<<'INPUT'
        LLR

        AAA = (BBB, BBB)
        BBB = (AAA, ZZZ)
        ZZZ = (ZZZ, ZZZ)
        INPUT
    );

    $this->assertSame(6, $command->solutionOne());
});

it('should return 6 with example input for puzzle two', function () {
    $command = new Day08(
        <<<'INPUT'
        LR

        11A = (11B, XXX)
        11B = (XXX, 11Z)
        11Z = (11B, XXX)
        22A = (22B, XXX)
        22B = (22C, 22C)
        22C = (22Z, 22Z)
        22Z = (22B, 22B)
        XXX = (XXX, XXX)
        INPUT
    );

    $this->assertSame(6, $command->solutionTwo());
});
