<?php
namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function login()
    {
        $this->render('login', ['isLogin' => null]);
    }

    public function loginUser()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user = new User();
        $isLogin = $user->login($login, $password);
        if(!$isLogin)
        {
            $this->render('login', ['isLogin'=>false]);
        }
        else
        {
            session_start();
            $_SESSION['isLogin'] = true;
            Header("Location:/");
        }

    }

    public function isLogin()
    {
        session_start();
        return $_SESSION['isLogin'] === true;
    }

    public function logout()
    {
        session_start();
        $_SESSION['isLogin'] = null;
        Header("Location:/");
    }
};