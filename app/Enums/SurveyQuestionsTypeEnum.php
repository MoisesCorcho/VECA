<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum SurveyQuestionsTypeEnum: string
{
    case TYPE_TEXT     = 'text';
    case TYPE_TEXTAREA = 'textarea';
    case TYPE_SELECT   = 'select';
    case TYPE_RADIO    = 'radio';
    case TYPE_CHECKBOX = 'checkbox';
    case TYPE_DATE     = 'date';
    case TYPE_TIME     = 'time';

    public static function values(): collection
    {
        return collect(self::cases())->pluck('value');
    }

    public function label(): string
    {
        return match ($this) {
            self::TYPE_TEXT     => __('Text'),
            self::TYPE_TEXTAREA => __('Textarea'),
            self::TYPE_SELECT   => __('Select'),
            self::TYPE_RADIO    => __('Radio'),
            self::TYPE_CHECKBOX => __('Checkbox'),
            self::TYPE_DATE     => __('Date'),
            self::TYPE_TIME     => __('Time'),
        };
    }

    public static function keyValuesCombined(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn($case) => $case->label(), self::cases())
        );
    }

    public static function nonOptionsTypes(): array
    {
        return collect(self::cases())
            ->pluck('value')
            ->filter(fn($value) => in_array($value, [self::TYPE_TEXT->value, self::TYPE_TEXTAREA->value, self::TYPE_DATE->value, self::TYPE_TIME->value]))
            ->values()
            ->toArray();
    }
}
