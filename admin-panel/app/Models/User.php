<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'phone',
        'password',
        'first_name',
        'last_name',
        'email_verified_at',
        'phone_verified_at',
        'avatar_id',
        'package_id',
        'is_premium',
        'real_identity_id',
        'socials',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
        'socials' => 'array'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function routeNotificationForKavenegar($driver, $notification = null)
    {
        return $this->phone;
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    /**
     * Get the real identity associated with the user.
     */
    public function realIdentity()
    {
        return $this->belongsTo(RealIdentity::class,'real_identity_id');
    }
}
