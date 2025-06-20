<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Enums\DniType;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ModelUtilityTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, ModelUtilityTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'cellphone',
        'dni_type',
        'dni',
        'active',
        'visits_per_day',
        'survey_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dni_type' => DniType::class,
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function () {

                if (empty($this->last_name)) return $this->name;

                return $this->name . ' ' . $this->last_name;
            },
        );
    }

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    // If it is an admin
    public function surveysCreated(): HasMany
    {
        return $this->hasMany(Survey::class, 'user_id');
    }

    // If it is a seller
    public function assignedSurvey(): BelongsTo
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }


    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
