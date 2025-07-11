<?php

namespace App\Enums;

use App\Models\Member;
use App\Models\MemberPosition;
use App\Models\Organization;
use Illuminate\Support\Collection;

enum ModelOptionSourceEnum: string
{
    case ORGANIZATION = Organization::class;
    case MEMBER = Member::class;
    case MEMBER_POSITION = MemberPosition::class;

    public static function values(): collection
    {
        return collect(self::cases())->pluck('value');
    }

    public function label(): string
    {
        return match ($this) {
            self::ORGANIZATION => __('Organizations - Clients'),
            self::MEMBER => __('Members - Client Employees'),
            self::MEMBER_POSITION => __('Member Positions - Client Employee Positions'),
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
