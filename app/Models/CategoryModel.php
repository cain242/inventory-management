<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * HAFTA 2 — Öğrenci 2
 *
 * Kategori modeli. Allowed fields, validation kuralları vs. eklenecek.
 */
class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    // TODO: allowedFields, validationRules
    protected $allowedFields = [];
}
