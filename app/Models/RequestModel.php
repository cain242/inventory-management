<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * HAFTA 3 — Öğrenci 3
 */
class RequestModel extends Model
{
    protected $table            = 'requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    // TODO: allowedFields, validationRules
    protected $allowedFields = [];
}
