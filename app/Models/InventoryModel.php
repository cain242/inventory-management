<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * HAFTA 2 — Öğrenci 2
 */
class InventoryModel extends Model
{
    protected $table            = 'inventory';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    // TODO: allowedFields, validationRules, relation helpers
    protected $allowedFields = [];
}
