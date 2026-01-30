<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'slug',
        'name',
        'email',
        'dialcode',
        'phone',
        'password',
        'avatar',
        'avatar_path',
        'gender',
        'address',
        'city',
        'state',
        'zipcode',
        'iso2',
        'role',
        'status',
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
            'password'          => 'hashed',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            $firstInitial = $this->name ? strtoupper(substr($this->name, 0, 1)) : '';
            $lastInitial  = $this->name  ? strtoupper(substr($this->name, 1, 1)) : strtoupper(substr($this->name, 1, 1));

            // If no last name, just return first initial
            return $firstInitial . $lastInitial;
        });
    }

    protected function fullname(): Attribute
    {
        return Attribute::get(function () {
            $name = $this->name ? $this->name : '';
            return $name;
        });
    }

    /**
     * Get all of the linkedVehicles for the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function linkedVehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'user_id', 'id');
    }

     /**
     * Get all of the notes for the User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(UserNote::class, 'user_id', 'id');
    }
}
