<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifyEmailTes;

class User extends Authenticatable implements MustVerifyEmail
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
        'phone',
        'roles',
        'fcm_id',

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
        'password' => 'hashed',
    ];

    protected $primaryKey = 'id_user';



    public function personalData()
    {
        return $this->hasOne(PersonalData::class, 'id_user');
    }

    public function hasRole($roles)
    {
        return $this->roles()->where('name', $roles)->exists();
    }

    public function isAdmin()
    {
        return $this->roles === 'ADMIN';
    }

    // Pada model User.php
    public function sendVerificationEmail()
    {
        $verificationUrl = URL::signedRoute('verification.verify2', ['id_user' => $this->id_user]);

        // Kirim email verifikasi ke pengguna
        Mail::to($this->email)->send(new VerifyEmailTes($verificationUrl));
    }
}
