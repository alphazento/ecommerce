<?php

namespace Zento\Passport\Model;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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

    public function findForPassport($username) {
        return $this->where('email', $username)->first();
    }
    
    public function randomPassword() {
        return Str::random(16);
    }

    public function applyRandomPassword() {
        $password = $this->randomPassword();
        $this->password = Hash::make($password);
        $this->save();
        return $password;
    }

    /**
     * limit user only can access its resources
     *
     * @param boolean $isMe
     * @return boolean
     */
    public function crossUserAcl($isMe = false) {
        return $isMe;
    }

    public function acl($request) {
        (new \Zento\Passport\Passport)->callPostAuthcateHooks($this, $request);
    }
}
