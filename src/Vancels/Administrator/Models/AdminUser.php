<?php

namespace Vancels\Administrator\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\AdminUser
 *
 * @property-read mixed  $name
 * @property-write mixed $password
 * @mixin \Eloquent
 */
class AdminUser extends Authenticatable
{
    use Notifiable, AdminCommonModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setPasswordAttribute($value)
    {
        if ($value != "") {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}