<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'firstname',
        'lastname',
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
            'password' => 'hashed',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['firstname', 'lastname'])
            ->saveSlugsTo('slug');
    }

    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            $firstInitial = $this->firstname ? strtoupper(substr($this->firstname, 0, 1)) : '';
            $lastInitial  = $this->lastname  ? strtoupper(substr($this->lastname, 0, 1)) : strtoupper(substr($this->firstname, 1, 1));

            // If no last name, just return first initial
            return $firstInitial . $lastInitial;
        });
    }

    protected function fullname(): Attribute
    {
        return Attribute::get(function () {
            $firstname = $this->firstname ? $this->firstname : '';
            $lastname  = $this->lastname  ? $this->lastname : '';

            return $firstname . ' ' . $lastname;
        });
    }
}
