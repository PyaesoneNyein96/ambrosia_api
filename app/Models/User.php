<?php

namespace App\Models;

use App\Models\Tag;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;



    public function Tag(){
        // return $this->belongTo(Tag::class);
        return $this->belongsTo(Tag::class,'preferred_cuisine');
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'birthday',
        'address',
        'gender',
        'role',
        'image',
        'restrictions',
        'allergies',
        'preferred_cuisine',
        'membership',
        // 'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',


        //customize hide this ... :X
        'current_team_id',
        'profile_photo_path',
        'profile_photo_url',
        'email_verified_at',
        'two_factor_confirmed_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
}