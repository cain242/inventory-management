<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\InventoryImageModel;
use App\Models\CategoryModel;

/**
 * =====================================================================
 * HAFTA 2 — Öğrenci 2: Envanter (Ürün) Yönetimi
 * =====================================================================
 */
class InventoryController extends BaseController
{
    protected $inventory;
    protected $images;
    protected $categories;

    public function __construct()
    {
        $this->inventory  = new InventoryModel();
        $this->images     = new InventoryImageModel();
        $this->categories = new CategoryModel();
    }

    /**
     * Envanter Listesi - Arama ve Filtreleme dahil.
     * Route: GET /admin/inventory
     */
    public function index()
    {
        $brand    = $this->request->getGet('brand');
        $category = $this->request->getGet('category');

        // QueryBuilder ile JOIN işlemi: Kategorinin ismini de alıyoruz
        $builder = $this->inventory->select('inventory.*, categories.name as category_name')
                                   ->join('categories', 'categories.id = inventory.category_id', 'left');

        if ($brand) {
            $builder->like('inventory.brand', $brand);
        }

        if ($category) {
            $builder->where('inventory.category_id', $category);
        }

        $data = [
            'inventory'  => $builder->orderBy('inventory.id', 'DESC')->findAll(),
            'categories' => $this->categories->orderBy('name', 'ASC')->findAll(), // Filtre dropdown'ı için
            'filter'     => ['brand' => $brand, 'category' => $category]
        ];

        return view('admin/inventory/index', $data);
    }

    /**
     * Yeni Ürün Formu
     * Route: GET /admin/inventory/create
     */
    public function create()
    {
        return view('admin/inventory/create', [
            'categories' => $this->categories->orderBy('name', 'ASC')->findAll()
        ]);
    }

    /**
     * Yeni Ürün Kaydı
     * Route: POST /admin/inventory
     */
    public function store()
    {
        $rules = [
            'category_id'   => 'required|is_not_unique[categories.id]',
            'name'          => 'required|min_length[3]|max_length[255]',
            'status'        => 'required|in_list[boşta,kullanımda,arızalı]',
            'purchase_date' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->inventory->insert([
            'category_id'   => $this->request->getPost('category_id'),
            'name'          => $this->request->getPost('name'),
            'serial_no'     => $this->request->getPost('serial_no'),
            'brand'         => $this->request->getPost('brand'),
            'purchase_date' => $this->request->getPost('purchase_date') ?: null,
            'status'        => $this->request->getPost('status'),
            'notes'         => $this->request->getPost('notes'),
        ]);

        return redirect()->to('/admin/inventory')->with('success', 'Ürün başarıyla eklendi.');
    }

    /**
     * Ürün Detay ve Görsel Galerisi
     * Route: GET /admin/inventory/(:num)
     */
    public function show($id)
    {
        $item = $this->inventory->select('inventory.*, categories.name as category_name')
                                ->join('categories', 'categories.id = inventory.category_id', 'left')
                                ->find($id);

        if (!$item) {
            return redirect()->to('/admin/inventory')->with('error', 'Ürün bulunamadı.');
        }

        return view('admin/inventory/show', [
            'item'   => $item,
            'images' => $this->images->where('inventory_id', $id)->findAll()
        ]);
    }

    /**
     * Ürün Düzenleme Formu
     * Route: GET /admin/inventory/(:num)/edit
     */
    public function edit($id)
    {
        $item = $this->inventory->find($id);
        if (!$item) return redirect()->to('/admin/inventory')->with('error', 'Ürün bulunamadı.');

        return view('admin/inventory/edit', [
            'item'       => $item,
            'categories' => $this->categories->orderBy('name', 'ASC')->findAll()
        ]);
    }

    /**
     * Ürün Güncelleme
     * Route: POST /admin/inventory/(:num)
     */
    public function update($id)
    {
        if (!$this->inventory->find($id)) return redirect()->to('/admin/inventory')->with('error', 'Ürün bulunamadı.');

        $rules = [
            'category_id' => 'required|is_not_unique[categories.id]',
            'name'        => 'required|min_length[3]|max_length[255]',
            'status'      => 'required|in_list[boşta,kullanımda,arızalı]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->inventory->update($id, [
            'category_id'   => $this->request->getPost('category_id'),
            'name'          => $this->request->getPost('name'),
            'serial_no'     => $this->request->getPost('serial_no'),
            'brand'         => $this->request->getPost('brand'),
            'purchase_date' => $this->request->getPost('purchase_date') ?: null,
            'status'        => $this->request->getPost('status'),
            'notes'         => $this->request->getPost('notes'),
        ]);

        return redirect()->to('/admin/inventory')->with('success', 'Ürün güncellendi.');
    }

    /**
     * Ürün Silme
     * Route: POST /admin/inventory/(:num)/delete
     */
    public function delete($id)
    {
        try {
            // Önce bu ürüne bağlı görselleri temizlemek iyi bir pratiktir
            $itemImages = $this->images->where('inventory_id', $id)->findAll();
            foreach ($itemImages as $img) {
                @unlink(ROOTPATH . 'public/' . $img['file_path']);
            }
            
            $this->inventory->delete($id);
            return redirect()->to('/admin/inventory')->with('success', 'Ürün ve bağlı görseller silindi.');
        } catch (\Exception $e) {
            return redirect()->to('/admin/inventory')->with('error', 'Bu ürün silinemez (Zimmetli olabilir).');
        }
    }

    /**
     * Görsel Yükleme
     * Route: POST /admin/inventory/(:num)/images
     */
    public function uploadImage($id)
    {
        $files = $this->request->getFiles();

        if (isset($files['images'])) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    // public/uploads/inventory altına taşı
                    $file->move(ROOTPATH . 'public/uploads/inventory', $newName);

                    $this->images->insert([
                        'inventory_id' => $id,
                        'file_path'    => 'uploads/inventory/' . $newName
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Görseller yüklendi.');
    }

    /**
     * Görsel Silme
     * Route: POST /admin/inventory/images/(:num)/delete
     */
    public function deleteImage($imageId)
    {
        $image = $this->images->find($imageId);
        
        if ($image) {
            // Fiziksel dosyayı sil
            $path = ROOTPATH . 'public/' . $image['file_path'];
            if (file_exists($path)) {
                unlink($path);
            }
            // Veritabanı kaydını sil
            $this->images->delete($imageId);
        }

        return redirect()->back()->with('success', 'Görsel silindi.');
    }
}