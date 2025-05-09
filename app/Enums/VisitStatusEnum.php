<?php

namespace App\Enums;


enum VisitStatusEnum: string
{
    case SCHEDULED   = 'scheduled';
    case VISITED     = 'visited';
    case NOT_VISITED  = 'not-visited';
    case CANCELED    = 'canceled';
    case RESCHEDULED = 'rescheduled';

    public static function label()
    {
        return match ($this) {
            self::SCHEDULED => __('Scheduled'),
            self::VISITED => __('Visited'),
            self::NOT_VISITED => __('Not Visited'),
            self::CANCELED => __('Canceled'),
            self::RESCHEDULED => __('Rescheduled'),
        };
    }
}
