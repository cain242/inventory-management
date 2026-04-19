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
class RequestController extends BaseController
{
    // TODO: Hafta 3'te doldurulacak
}
