<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

/**
 * =====================================================================
 * HAFTA 4 — Öğrenci 4
 * =====================================================================
 * Zimmet (Assignment) yönetimi burada doldurulacak.
 *
 * Teknik görevler:
 *   - Bir envanter kaydını bir personele zimmetle
 *   - Envanterin status'unu "in_use" yap
 *   - İade işlemi: returned_at doldur, inventory.status = "available"
 *
 * Bağımlılıklar:
 *   - App\Models\AssignmentModel
 *   - App\Models\InventoryModel (Öğrenci 2)
 *   - app/Database/Migrations/...CreateAssignmentsTable.php
 *   - app/Views/admin/assignments/ klasörü
 *
 * Route'lar app/Config/Routes.php içinde hazırlanmış; yorum satırlarını aç.
 * =====================================================================
 */
class AssignmentController extends BaseController
{
    // TODO: Hafta 4'te doldurulacak
}
