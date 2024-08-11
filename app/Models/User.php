<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DateTimeInterface;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];
    // public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    // {
    //     return $this->tokens()->create([
    //         'name' => $name,
    //         'abilities' => $abilities,
    //         'expires_at' => $expiresAt,
    //     ]);
    // }
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }

    // Relationship to consultations where the user is the professional
    public function professionalConsultations()
    {
        return $this->hasMany(Consultation::class, 'professional_id');
    }
}
