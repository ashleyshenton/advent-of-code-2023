<?php

namespace App\Enums\Day07;

enum Hand: int
{
    case FiveOfAKind = 7;
    case FourOfAKind = 6;
    case FullHouse = 5;
    case ThreeOfAKind = 4;
    case TwoPair = 3;
    case OnePair = 2;
    case HighCard = 1;
}
