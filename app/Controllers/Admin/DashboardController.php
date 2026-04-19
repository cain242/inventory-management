<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    /**
     * Admin ana sayfası.
     *
     * HAFTA 5 — Öğrenci 5:
     *   Aşağıdaki $stats dizisi modellerden gerçek verilerle doldurulacak.
     *     - total_inventory    : InventoryModel::countAllResults()
     *     - pending_requests   : RequestModel::where('status','pending')->countAllResults()
     *     - active_assignments : AssignmentModel::where('returned_at', null)->countAllResults()
     *     - total_users        : Shield UserModel::countAllResults()
     */
    public function index()
    {
        $stats = [
            'total_inventory'    => 0,
            'pending_requests'   => 0,
            'active_assignments' => 0,
            'total_users'        => 0,
        ];

        return view('admin/dashboard', [
            'title'       => 'Yönetici Paneli',
            'currentUser' => $this->data['currentUser'],
            'stats'       => $stats,
        ]);
    }
}
