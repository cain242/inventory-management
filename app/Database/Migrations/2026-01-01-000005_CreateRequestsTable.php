<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * =====================================================================
 * HAFTA 3 — Öğrenci 3
 * =====================================================================
 * Talepler tablosu burada oluşturulacak.
 *
 * Kolonlar: id, user_id (FK), inventory_id (FK, nullable), type (enum),
 *           description, status (enum), admin_note, approved_by (FK),
 *           decided_at, created_at, updated_at
 * =====================================================================
 */
class CreateRequestsTable extends Migration
{
    public function up()
    {
        // TODO: Hafta 3'te doldurulacak
    }

    public function down()
    {
        $this->forge->dropTable('requests', true);
    }
}
