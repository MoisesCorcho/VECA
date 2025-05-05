<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

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
}
