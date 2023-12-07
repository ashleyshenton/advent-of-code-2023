<?php

declare(strict_types=1);

use App\Commands\Day07;
use App\Enums\Day07\Hand;

it('should return 6440 with example input', function () {
    $command = new Day07(
        <<<'INPUT'
        32T3K 765
        T55J5 684
        KK677 28
        KTJJT 220
        QQQJA 483
        INPUT
    );

    $this->assertSame(6440, $command->solutionOne());
});

it('should return 5905 with example input', function () {
    $command = new Day07(
        <<<'INPUT'
        32T3K 765
        T55J5 684
        KK677 28
        KTJJT 220
        QQQJA 483
        INPUT
    );

    $this->assertSame(5905, $command->solutionTwo());
});

it('should return three of a kind with jokers', function () {
    $command = new Day07(
        <<<'INPUT'
        AA23J 765
        INPUT
    );

    $hand = 'AA23J';

    $this->assertEquals(Hand::ThreeOfAKind, $command->partTwoHand(str_split($hand)));
});

it('should return one pair with jokers', function () {
    $command = new Day07(
        <<<'INPUT'
        A423J 765
        INPUT
    );

    $hand = 'A423J';

    $this->assertEquals(Hand::OnePair, $command->partTwoHand(str_split($hand)));
});
