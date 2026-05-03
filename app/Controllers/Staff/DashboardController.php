<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

use App\Models\RequestModel;

class DashboardController extends BaseController
{
    /**
     * Personel ana sayfası.
     */
    public function index()
    {
        $requestModel = new RequestModel();
        $userId = session()->get('user_id');
        
        $requests = $requestModel->getRequestsWithDetails($userId);
        // Sadece en son 5 talebi alalım
        $recentRequests = array_slice($requests, 0, 5);
        
        return view('staff/dashboard', [
            'title'          => 'Personel Paneli',
            'currentUser'    => $this->data['currentUser'],
            'recentRequests' => $recentRequests,
        ]);
    }
}
