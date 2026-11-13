<?php

namespace App\Enums;

enum ListingCondition: string
{
    case New = 'new';
    case VeryGood = 'very_good';
    case Good = 'good';
    case ForParts = 'for_parts';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Neuf',
            self::VeryGood => 'Très bon état',
            self::Good => 'Bon état',
            self::ForParts => 'Pour pièces',
        };
    }
}
