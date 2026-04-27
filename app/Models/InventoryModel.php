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
    protected $useTimestamps    = true; // created_at ve updated_at otomatik dolar

    // Controller'dan gelen verilerin kaydedilebilmesi için bu alanlar ŞART
    protected $allowedFields = [
        'category_id', 
        'name', 
        'serial_no', 
        'brand', 
        'purchase_date', 
        'status', 
        'notes'
    ];

    // İstersen buraya validationRules da ekleyebilirsin ama biz Controller'da hallettik.
}