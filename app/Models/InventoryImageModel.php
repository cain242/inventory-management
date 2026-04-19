<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * HAFTA 2 — Öğrenci 2
 */
class InventoryImageModel extends Model
{
    protected $table            = 'inventory_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    // TODO: allowedFields
    protected $allowedFields = [];
}
