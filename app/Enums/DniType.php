<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum DniType: string
{
    case CC = 'CC';
    case TI = 'TI';

    public static function values(): collection
    {
        return collect(self::cases())->pluck('value');
    }

    public function label(): string
    {
        return match ($this) {
            self::CC     => __('CC - Cédula de Ciudadanía'),
            self::TI => __('TI - Tarjeta de Identidad'),
        };
    }

    public static function keyValuesCombined(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }
}
