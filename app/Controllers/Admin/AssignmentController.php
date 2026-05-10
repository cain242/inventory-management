<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AssignmentModel;

/**
 * =====================================================================
 * HAFTA 4 — Öğrenci 4
 * =====================================================================
 * Zimmet (Assignment) yönetimi.
 *
 * Teknik görevler:
 *   - Zimmet kayıtlarını listele
 *   - Zimmet detayını göster
 *   - Yazdırılabilir zimmet tutanağı
 *
 * Bağımlılıklar:
 *   - App\Models\AssignmentModel
 *   - App\Models\InventoryModel (Öğrenci 2)
 *   - app/Views/admin/assignments/ klasörü
 *
 * Route'lar app/Config/Routes.php içinde Hafta 4 bloğunda.
 * =====================================================================
 */
class AssignmentController extends BaseController
{
    /**
     * Tüm zimmet kayıtlarını listeler.
     */
    public function index()
    {
        $assignmentModel = new AssignmentModel();

        $assignments = $assignmentModel->getAssignmentsWithDetails();

        return view('admin/assignments/index', [
            'title'       => 'Zimmet Kayıtları',
            'assignments' => $assignments,
        ]);
    }

    /**
     * Tek bir zimmet kaydının detayını gösterir.
     */
    public function show($id)
    {
        $assignmentModel = new AssignmentModel();

        $assignment = $assignmentModel->getAssignmentWithDetails($id);

        if (!$assignment) {
            return redirect()->to('/admin/assignments')->with('error', 'Zimmet kaydı bulunamadı.');
        }

        return view('admin/assignments/show', [
            'title'      => 'Zimmet Detayı',
            'assignment' => $assignment,
        ]);
    }

    /**
     * Yazdırılabilir zimmet tutanağı sayfası.
     */
    public function print($id)
    {
        $assignmentModel = new AssignmentModel();

        $assignment = $assignmentModel->getAssignmentWithDetails($id);

        if (!$assignment) {
            return redirect()->to('/admin/assignments')->with('error', 'Zimmet kaydı bulunamadı.');
        }

        return view('admin/assignments/print', [
            'title'      => 'Zimmet Tutanağı',
            'assignment' => $assignment,
        ]);
    }
}
