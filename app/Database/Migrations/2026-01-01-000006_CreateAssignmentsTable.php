<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * =====================================================================
 * HAFTA 4 — Öğrenci 4
 * =====================================================================
 * Zimmet (Assignment) tablosu burada oluşturulacak.
 *
 * Kolonlar: id, inventory_id (FK), user_id (FK), approved_by (FK),
 *           assigned_at, returned_at (nullable), note
 * =====================================================================
 */
class CreateAssignmentsTable extends Migration
{
    public function up()
    {
        // TODO: Hafta 4'te doldurulacak
    }

    public function down()
    {
        $this->forge->dropTable('assignments', true);
    }
}
