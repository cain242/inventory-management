<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Giriş noktası. Oturum yoksa login'e,
     * varsa kullanıcının grubuna göre ilgili dashboard'a yönlendirir.
     */
    public function index()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        return redirect()->to($this->getRedirectURL());
    }

    /**
     * Kullanıcının grubuna göre yönlendirme URL'i döner.
     * Shield groups sistemi kullanılır.
     */
    public function getRedirectURL(): string
    {
        $user = auth()->user();

        if ($user && $user->inGroup('admin')) {
            return '/admin/dashboard';
        }

        if ($user && $user->inGroup('staff')) {
            return '/staff/dashboard';
        }

        return '/login';
    }
}
