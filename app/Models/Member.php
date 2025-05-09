<?php

namespace App\Models;

use App\Enums\DniType;
use App\Traits\AddressTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory, HasUuids, AddressTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'dni_type',
        'dni',
        'cellphone_1',
        'cellphone_2',
        'phone',
        'birthdate',
        'email',
        'organization_id',
        'member_position_id',
    ];

    protected function casts(): array
    {
        return [
            'birthdate' => 'datetime',
            'dni_type' => DniType::class,
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function memberPosition(): BelongsTo
    {
        return $this->belongsTo(MemberPosition::class);
    }
}
