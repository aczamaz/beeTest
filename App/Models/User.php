<?php
namespace App\Models;

class User extends BaseModel 
{
    public function login($login,$password)
    {
        $users = $this->start()->from('users')->where(['login'=>$login,'password'=>$password]);
        $isLogin = $users->count() > 0;
        return $isLogin;
    }
}