<?php

namespace App\Enums;

enum SecretExpirationOptions: int
{
    case FiveMinutes = 1;
    case OneHour = 2;
    case OneDay = 3;
    case SevenDays = 4;
    case OneMonth = 5;

    public static function getOptions(): array
    {
        return [
            self::FiveMinutes->value => '5 minutos',
            self::OneHour->value => '1 hora',
            self::OneDay->value => '1 día',
            self::SevenDays->value => '7 días',
            self::OneMonth->value => '1 mes',
        ];
    }

    public function getExpiration(): string
    {
        return match ($this) {
            self::FiveMinutes => now()->addMinutes(5),
            self::OneHour => now()->addHour(),
            self::OneDay => now()->addDay(),
            self::SevenDays => now()->addDays(7),
            self::OneMonth => now()->addMonth(),
        };
    }
}
