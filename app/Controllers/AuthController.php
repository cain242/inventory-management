<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    
    public function login()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('auth/login', ['title' => 'Giriş Yap']);
    }

    public function loginAction()
    {
        $login    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // E-posta mı yoksa kullanıcı adı mı girilmiş?
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $type      => $login,
            'password' => $password,
        ];

        // Beni hatırla - attempt() öncesinde ayarlanmalı
        if ($this->request->getPost('remember')) {
            auth('session')->remember();
        }

        // Shield ile kimlik doğrulama
        $result = auth('session')->attempt($credentials);

        if (! $result->isOK()) {
            return redirect()->back()->with('error', 'E-posta veya şifre hatalı.');
        }

        return redirect()->to('/');
    }


    public function logout()
    {
        auth()->logout();

        return redirect()->to('/login');
    }
}
