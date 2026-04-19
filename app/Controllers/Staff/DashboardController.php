<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    /**
     * Personel ana sayfası.
     * Hafta 1'de sadece karşılama ekranı.
     * Hafta 3'te RequestModel hazır olunca "taleplerim" özeti eklenecek.
     */
    public function index()
    {
        return view('staff/dashboard', [
            'title'       => 'Personel Paneli',
            'currentUser' => $this->data['currentUser'],
        ]);
    }
}
