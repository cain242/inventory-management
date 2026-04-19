<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

/**
 * =====================================================================
 * HAFTA 2 — Öğrenci 2
 * =====================================================================
 * Envanter (ürün) yönetimi burada doldurulacak.
 *
 * Teknik görevler:
 *   - Envanter kaydı: ürün adı, seri numarası, alım tarihi, durum
 *     (boşta / kullanımda / arızalı)
 *   - Görsel yönetimi: public/uploads/inventory altına yükleme
 *   - Arama / filtreleme: marka veya kategoriye göre
 *
 * Bağımlılıklar:
 *   - App\Models\InventoryModel
 *   - App\Models\InventoryImageModel
 *   - app/Database/Migrations/...CreateInventoryTable.php
 *   - app/Database/Migrations/...CreateInventoryImagesTable.php
 *   - app/Views/admin/inventory/ klasörü
 *
 * Route'lar app/Config/Routes.php içinde hazırlanmış; yorum satırlarını aç.
 * =====================================================================
 */
class InventoryController extends BaseController
{
    // TODO: Hafta 2'de doldurulacak
}
