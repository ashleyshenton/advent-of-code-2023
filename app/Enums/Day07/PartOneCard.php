<?php

namespace App\Enums\Day07;

enum PartOneCard: int
{
    case Two = 2;
    case Three = 3;
    case Four = 4;
    case Five = 5;
    case Six = 6;
    case Seven = 7;
    case Eight = 8;
    case Nine = 9;
    case Ten = 10;
    case Jack = 11;
    case Queen = 12;
    case King = 13;
    case Ace = 14;

    public static function parse(string $card): self
    {
        return match ($card) {
            '2' => self::Two,
            '3' => self::Three,
            '4' => self::Four,
            '5' => self::Five,
            '6' => self::Six,
            '7' => self::Seven,
            '8' => self::Eight,
            '9' => self::Nine,
            'T' => self::Ten,
            'J' => self::Jack,
            'Q' => self::Queen,
            'K' => self::King,
            'A' => self::Ace,
        };
    }
}
