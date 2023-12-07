<?php

declare(strict_types=1);

namespace App\Commands;

use App\Enums\Day07\Hand;
use App\Enums\Day07\PartOneCard;
use App\Enums\Day07\PartTwoCard;

class Day07 extends Day
{
    public function solutionOne(): int
    {
        $lines = array_map(fn (string $line) => explode(' ', $line), explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)));

        usort($lines, function (array $a, array $b) {
            $aCards = str_split($a[0]);
            $bCards = str_split($b[0]);

            $aHand = $this->partOneHand($aCards);
            $bHand = $this->partOneHand($bCards);

            if ($aHand === $bHand) {
                foreach ($aCards as $key => $card) {
                    $aCard = PartOneCard::parse($card);
                    $bCard = PartOneCard::parse($bCards[$key]);

                    if ($aCard !== $bCard) {
                        return $aCard->value <=> $bCard->value;
                    }
                }
            }

            return $aHand->value <=> $bHand->value;
        });

        return collect($lines)->reduce(fn (int $carry, array $item, int $key) => $carry + $item[1] * ($key + 1), 0);
    }

    public function partOneHand(array $cards): Hand
    {
        $cardCounts = array_count_values($cards);

        if (in_array(5, $cardCounts)) {
            return Hand::FiveOfAKind;
        }

        if (in_array(4, $cardCounts)) {
            return Hand::FourOfAKind;
        }

        if (in_array(3, $cardCounts) && in_array(2, $cardCounts)) {
            return Hand::FullHouse;
        }

        if (in_array(3, $cardCounts)) {
            return Hand::ThreeOfAKind;
        }

        $numberOfPairs = array_count_values($cardCounts)[2] ?? 0;

        if ($numberOfPairs === 2) {
            return Hand::TwoPair;
        }

        if (in_array(2, $cardCounts)) {
            return Hand::OnePair;
        }

        return Hand::HighCard;
    }

    public function partTwoHand(array $cards): Hand
    {
        $cardCounts = array_count_values($cards);

        $jokerCount = $cardCounts['J'] ?? 0;
        unset($cardCounts['J']);
        $max = max($cardCounts ?: [0]);
        $maxWithJokers = $max + $jokerCount;

        if (in_array(5, $cardCounts) || $maxWithJokers === 5) {
            return Hand::FiveOfAKind;
        }

        if (in_array(4, $cardCounts) || $maxWithJokers === 4) {
            return Hand::FourOfAKind;
        }

        if ($maxWithJokers === 3) {
            $cardCountsWithoutMax = $cardCounts;
            $index = array_search($max, $cardCountsWithoutMax);
            unset($cardCountsWithoutMax[$index]);

            if (in_array(2, $cardCountsWithoutMax)) {
                return Hand::FullHouse;
            }
        }

        if (in_array(3, $cardCounts) || $maxWithJokers === 3) {
            return Hand::ThreeOfAKind;
        }

        $numberOfPairs = array_count_values($cardCounts)[2] ?? 0;

        if ($numberOfPairs === 2) {
            return Hand::TwoPair;
        }

        if (in_array(2, $cardCounts) || $maxWithJokers === 2) {
            return Hand::OnePair;
        }

        return Hand::HighCard;
    }

    public function solutionTwo(): int
    {
        $lines = array_map(fn (string $line) => explode(' ', $line), explode(PHP_EOL, rtrim($this->puzzleInput, PHP_EOL)));

        usort($lines, function (array $a, array $b) {
            $aCards = str_split($a[0]);
            $bCards = str_split($b[0]);

            $aHand = $this->partTwoHand($aCards);
            $bHand = $this->partTwoHand($bCards);

            if ($aHand === $bHand) {
                foreach ($aCards as $key => $card) {
                    $aCard = PartTwoCard::parse($card);
                    $bCard = PartTwoCard::parse($bCards[$key]);

                    if ($aCard !== $bCard) {
                        return $aCard->value <=> $bCard->value;
                    }
                }
            }

            return $aHand->value <=> $bHand->value;
        });

        return collect($lines)->reduce(fn (int $carry, array $item, int $key) => $carry + $item[1] * ($key + 1), 0);
    }
}
