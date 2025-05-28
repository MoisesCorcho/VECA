<?php

namespace App\Enums;


enum VisitStatusEnum: string
{
    case SCHEDULED   = 'scheduled';
    case VISITED     = 'visited';
    case NOT_VISITED  = 'not-visited';
    case CANCELED    = 'canceled';
    case RESCHEDULED = 'rescheduled';

    public function label()
    {
        return match ($this) {
            self::SCHEDULED => __('Scheduled'),
            self::VISITED => __('Visited'),
            self::NOT_VISITED => __('Not Visited'),
            self::CANCELED => __('Canceled'),
            self::RESCHEDULED => __('Rescheduled'),
        };
    }

    public static function keyValuesCombined(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }

    public static function colors()
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            ['#3788d8', '#10b981', '#ef4444', '#ef4444', '#f59e0b']
        );
    }
}
