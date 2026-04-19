<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * HAFTA 1 — Çekirdek
 *
 * Admin grubunda olmayan kullanıcıları staff dashboard'a yönlendirir.
 * Shield'in group sistemi kullanılır.
 */
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = auth()->user();

        if (! $user || ! $user->inGroup('admin')) {
            return redirect()->to('/staff/dashboard')->with('error', 'Bu alana erişim yetkiniz yok.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // İşlem yok
    }
}
