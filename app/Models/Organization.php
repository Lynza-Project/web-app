<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'logo',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(static function ($organization) {
            $organization->addresses()->delete();
        });
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class);
    }
}
