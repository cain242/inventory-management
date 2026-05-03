<?php

namespace App\Controllers\Staff;

use App\Controllers\BaseController;

/**
 * =====================================================================
 * HAFTA 3 — Öğrenci 3
 * =====================================================================
 * Personelin talep oluşturma ve kendi taleplerini listeleme modülü.
 *
 * Teknik görevler:
 *   - Talep formu: "Arıza Bildirimi" veya "Yeni Ekipman Talebi"
 *   - İlişkisel veri: Talebin hangi kullanıcı tarafından, hangi
 *                     envanter parçası için yapıldığı
 *   - Validasyon: Boş bırakılamaz, max karakter, vs.
 *   - Güvenlik: Kullanıcı sadece kendi talebini görebilmeli
 *
 * Bağımlılıklar:
 *   - App\Models\RequestModel
 *   - App\Models\InventoryModel (Öğrenci 2)
 *   - app/Database/Migrations/...CreateRequestsTable.php
 *   - app/Views/staff/requests/ klasörü
 *
 * Route'lar app/Config/Routes.php içinde hazırlanmış; yorum satırlarını aç.
 * =====================================================================
 */
use App\Models\RequestModel;
use App\Models\InventoryModel;
use App\Models\CategoryModel;

class RequestController extends BaseController
{
    public function index()
    {
        $requestModel = new RequestModel();
        $userId = session()->get('user_id');
        
        $data['requests'] = $requestModel->getRequestsWithDetails($userId);
        
        return view('staff/requests/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();
        $inventoryModel = new InventoryModel();

        // Kategorileri çek ve her birinin ürün sayısını hesapla
        $categories = $categoryModel->findAll();
        foreach ($categories as &$cat) {
            $cat['item_count'] = $inventoryModel->where('category_id', $cat['id'])->countAllResults();
        }
        unset($cat);

        $data['categories'] = $categories;

        return view('staff/requests/create', $data);
    }

    /**
     * AJAX: Seçilen kategoriye göre envanter listesini JSON olarak döner.
     */
    public function getInventoryByCategory($categoryId)
    {
        $inventoryModel = new InventoryModel();
        $items = $inventoryModel->where('category_id', $categoryId)->findAll();

        return $this->response->setJSON($items);
    }

    public function store()
    {
        $requestModel = new RequestModel();
        
        $userId = session()->get('user_id');
        $type = $this->request->getPost('type');
        $description = $this->request->getPost('description');
        $inventoryId = $this->request->getPost('inventory_id');

        $data = [
            'user_id'      => $userId,
            'type'         => $type,
            'description'  => $description,
            'inventory_id' => $inventoryId,
            'status'       => 'pending'
        ];

        if ($requestModel->save($data)) {
            return redirect()->to('staff/requests')->with('success', 'Talebiniz başarıyla oluşturuldu.');
        } else {
            return redirect()->to('staff/requests/create')->withInput()->with('validation', $requestModel->errors());
        }
    }

    public function show($uuid)
    {
        $requestModel = new RequestModel();
        $userId = session()->get('user_id');
        
        $request = $requestModel->select('requests.*, inventory.name as inventory_name, inventory.serial_no')
                                ->join('inventory', 'inventory.id = requests.inventory_id', 'left')
                                ->where('requests.uuid', $uuid)
                                ->where('requests.user_id', $userId)
                                ->first();
                                
        if (!$request) {
            return redirect()->to('staff/requests')->with('error', 'Talep bulunamadı veya görüntüleme yetkiniz yok.');
        }

        $data['request'] = $request;
        return view('staff/requests/show', $data);
    }

    public function cancel($uuid)
    {
        $requestModel = new RequestModel();
        $userId = session()->get('user_id');
        
        $request = $requestModel->where('uuid', $uuid)->where('user_id', $userId)->first();
        
        if (!$request) {
            return redirect()->to('staff/requests')->with('error', 'Talep bulunamadı veya iptal etme yetkiniz yok.');
        }
        
        if ($request['status'] !== 'pending') {
            return redirect()->to('staff/requests')->with('error', 'Sadece bekleyen talepleri iptal edebilirsiniz.');
        }
        
        $requestModel->update($request['id'], ['status' => 'cancelled']);
        
        return redirect()->to('staff/requests')->with('success', 'Talebiniz başarıyla iptal edildi.');
    }
}
