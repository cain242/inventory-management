<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * HAFTA 4 — Öğrenci 4
 */
class AssignmentModel extends Model
{
    protected $table            = 'assignments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = false;

    // TODO: allowedFields
    protected $allowedFields = [];
}
