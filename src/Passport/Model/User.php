<?php

namespace Zento\Passport\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

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
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getEmail() {
        return $this->email;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsernameAttribute($value) {
        return $this->attribute['email'];
    }

    public function setUsernameAttribute($value) {
        $this->attribute['email'] = $value;
    }

    public function acl($routeName, $isMe = false) {
        if ($isMe) {
            return true;
        }
        return true;
    }
}
