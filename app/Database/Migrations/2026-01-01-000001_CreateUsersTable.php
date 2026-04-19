<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * =====================================================================
 * HAFTA 1 — Çekirdek
 * =====================================================================
 * Users tablosu artık Shield tarafından yönetilir.
 * Shield kendi migration'ları ile şu tabloları oluşturur:
 *   - users
 *   - auth_identities
 *   - auth_logins
 *   - auth_remember_tokens
 *   - auth_token_logins
 *   - auth_groups_users
 *   - auth_permissions_users
 *
 * Bu migration kasıtlı olarak boş bırakılmıştır.
 * Shield migration'ları: php spark migrate --all
 * =====================================================================
 */
class CreateUsersTable extends Migration
{
    public function up()
    {
        // Shield tabloları vendor/codeigniter4/shield migration'ları ile oluşturulur.
        // php spark migrate --all komutu hem Shield hem proje migration'larını çalıştırır.
    }

    public function down()
    {
        // Shield kendi tablolarını kendi down() metotlarıyla yönetir.
    }
}
