<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    /**
     * Login sayfasını göster.
     * Zaten giriş yapmışsa ana sayfaya yönlendir.
     */
    public function login()
    {
        if (auth()->loggedIn()) {
            return redirect()->to('/');
        }

        return view('auth/login', ['title' => 'Giriş Yap']);
    }

    /**
     * Login form verilerini işle.
     * Shield'in auth servisini kullanarak kimlik doğrulama yapar.
     * Session köprüsü Events.php'deki login event ile otomatik kurulur.
     */
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

        // Shield ile kimlik doğrulama
        $result = auth('session')->attempt($credentials);

        if (! $result->isOK()) {
            return redirect()->back()->with('error', 'E-posta veya şifre hatalı.');
        }

        // Beni hatırla
        if ($this->request->getPost('remember')) {
            auth('session')->rememberUser(auth()->id());
        }

        return redirect()->to('/');
    }

    /**
     * Çıkış yap.
     * Shield session ve remember token'ı temizler.
     * Events.php'deki logout event session köprüsünü temizler.
     */
    public function logout()
    {
        auth()->logout();

        return redirect()->to('/login');
    }
}
