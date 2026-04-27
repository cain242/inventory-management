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
    
    // Migration dosyasında sadece created_at varsa bunu true bırakabilirsin
    // ama updated_at yoksa hata almamak için dikkat et.
    protected $useTimestamps    = true; 

    protected $allowedFields = [
        'inventory_id', 
        'file_path'
    ];
}