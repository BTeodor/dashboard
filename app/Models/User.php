<?php

namespace App\Models;

use App\Presenters\UserPresenter;
use App\Support\Enum\UserStatus;


use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Laracodes\Presenter\Traits\Presentable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword,  Presentable, EntrustUserTrait;

    protected $presenter = UserPresenter::class;

    protected $table = 'users';


    protected $fillable = ['first_name', 'last_name', 'email', 'username', 'password', 'avatar', 'birthday', 'last_login', 'confirmation_token', 'status'];


    protected $hidden = ['password', 'remember_token'];



    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setBirthdayAttribute($value) {
        $this->attributes['birthday'] = trim($value) ?: null;
    }

    public function gravatar() {
        $hash = hash('md5', strtolower(trim($this->attributes['email'])));

        return sprintf("//www.gravatar.com/avatar/%s", $hash);
    }

    public function isUnconfirmed() {
        return $this->status == UserStatus::UNCONFIRMED;
    }

    public function isActive() {
        return $this->status == UserStatus::ACTIVE;
    }

    public function isBanned() {
        return $this->status == UserStatus::BANNED;
    }

    public function socialNetworks() {
        return $this->hasOne(UserSocialNetworks::class, 'user_id');
    }


    public function activities() {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function getFullNameAttribute() {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function getCriadoAttribute()
    {
        return $this->created_at->format('d/m/Y');
    }
}
