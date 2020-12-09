<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const ACCESS_SUPER_ADMIN = 7;
    const ACCESS_OPERATOR = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        'is_admin',
        'is_operator'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'work_country');
    }

    public function requests()
    {
        return $this->hasMany('App\Models\QAndA', 'responsible_user_id');
    }

    public static function getUserInfoById($id)
    {
        $user = User::with('country')->find($id);

        return $user;
    }

    public function isOperator(): bool
    {
        return $this->access === 4 || $this->access === null;
    }

    public function isAdmin(): bool
    {
        return $this->access === 7;
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdmin();        
    }

    public function getIsOperatorAttribute()
    {
        return $this->isOperator();        
    }
}
