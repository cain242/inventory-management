<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RequestModel;
use App\Models\InventoryModel;
use App\Models\AssignmentModel;

/**
 * =====================================================================
 * HAFTA 4 — Öğrenci 4
 * =====================================================================
 * Talep onay paneli.
 *
 * Teknik görevler:
 *   - Bekleyen talepleri listele (status: pending)
 *   - Onayla / Reddet / Açıklama yaz
 *   - Onaylandığında otomatik zimmet kaydı oluşturur
 *     (AssignmentController ile birlikte çalışır)
 *
 * Bağımlılıklar:
 *   - App\Models\RequestModel (Öğrenci 3 oluşturdu)
 *   - app/Views/admin/requests/ klasörü
 *
 * Route'lar app/Config/Routes.php içinde Hafta 4 bloğunda.
 * =====================================================================
 */
class RequestController extends BaseController
{
    /**
     * Tüm talepleri listeler — admin onay paneli.
     */
    public function index()
    {
        $requestModel = new RequestModel();

        $requests = $requestModel
            ->select('requests.*, inventory.name as inventory_name, inventory.serial_no, users.username as staff_name')
            ->join('inventory', 'inventory.id = requests.inventory_id', 'left')
            ->join('users', 'users.id = requests.user_id', 'left')
            ->orderBy('FIELD(requests.status, "pending", "approved", "rejected", "cancelled")')
            ->orderBy('requests.created_at', 'DESC')
            ->findAll();

        return view('admin/requests/index', [
            'title'    => 'Talep Onay Paneli',
            'requests' => $requests,
        ]);
    }

    /**
     * Talebi onaylar:
     *  1. requests tablosunda status → approved
     *  2. inventory tablosunda status → kullanımda
     *  3. assignments tablosuna yeni zimmet kaydı ekler
     */
    public function approve($id)
    {
        $requestModel    = new RequestModel();
        $inventoryModel  = new InventoryModel();
        $assignmentModel = new AssignmentModel();

        $request = $requestModel->find($id);

        if (!$request) {
            return redirect()->to('/admin/requests')->with('error', 'Talep bulunamadı.');
        }

        if ($request['status'] !== 'pending') {
            return redirect()->to('/admin/requests')->with('error', 'Bu talep zaten işlenmiş.');
        }

        $adminId = session()->get('user_id');

        // 1) Talebi onayla
        $requestModel->update($id, [
            'status'      => 'approved',
            'approved_by' => $adminId,
            'decided_at'  => date('Y-m-d H:i:s'),
        ]);

        // 2) Envanterin durumunu "kullanımda" yap
        if (!empty($request['inventory_id'])) {
            $inventoryModel->update($request['inventory_id'], [
                'status' => 'kullanımda',
            ]);

            // 3) Zimmet kaydı oluştur
            $assignmentModel->insert([
                'user_id'      => $request['user_id'],
                'inventory_id' => $request['inventory_id'],
                'request_id'   => $id,
                'approved_by'  => $adminId,
                'assigned_at'  => date('Y-m-d H:i:s'),
                'notes'        => 'Talep #' . $id . ' onayı ile otomatik zimmetlendi.',
            ]);
        }

        return redirect()->to('/admin/requests')->with('success', 'Talep başarıyla onaylandı ve cihaz zimmetlendi.');
    }

    /**
     * Talebi reddeder ve admin notunu kaydeder.
     */
    public function reject($id)
    {
        $requestModel = new RequestModel();

        $request = $requestModel->find($id);

        if (!$request) {
            return redirect()->to('/admin/requests')->with('error', 'Talep bulunamadı.');
        }

        if ($request['status'] !== 'pending') {
            return redirect()->to('/admin/requests')->with('error', 'Bu talep zaten işlenmiş.');
        }

        $adminNote = $this->request->getPost('admin_note');
        $adminId   = session()->get('user_id');

        $requestModel->update($id, [
            'status'      => 'rejected',
            'admin_note'  => $adminNote,
            'approved_by' => $adminId,
            'decided_at'  => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/requests')->with('success', 'Talep reddedildi.');
    }
}
