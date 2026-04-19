<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * HAFTA 1 — Çekirdek
 *
 * Giriş yapılmamış kullanıcıları login sayfasına yönlendirir.
 * Shield'in auth()->loggedIn() metodunu kullanır.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // İşlem yok
    }
}
