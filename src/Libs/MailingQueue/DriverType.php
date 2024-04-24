<?php

namespace App\Libs\MailingQueue;

enum DriverType: string
{
    case EMAIL = 'email';
    case TELEGRAM = 'telegram';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
