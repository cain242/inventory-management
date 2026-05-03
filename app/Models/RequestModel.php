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

    protected $allowedFields = [
        'uuid',
        'user_id',
        'inventory_id',
        'type',
        'description',
        'status',
        'admin_note',
        'approved_by',
        'decided_at'
    ];

    protected $beforeInsert = ['generateUuid'];

    protected function generateUuid(array $data): array
    {
        if (empty($data['data']['uuid'])) {
            $data['data']['uuid'] = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    protected $validationRules = [
        'type'         => 'required|in_list[repair,new]',
        'inventory_id' => 'required|integer',
        'description'  => 'permit_empty|max_length[500]'
    ];

    protected $validationMessages = [
        'type' => [
            'required' => 'Talep türü seçilmelidir.',
            'in_list'  => 'Geçersiz talep türü.',
        ],
        'inventory_id' => [
            'required' => 'Lütfen bir ürün seçiniz.',
            'integer'  => 'Geçersiz ürün seçimi.',
        ],
        'description' => [
            'max_length' => 'Açıklama en fazla 500 karakter olabilir.',
        ]
    ];

    public function getRequestsWithDetails($userId)
    {
        return $this->select('requests.*, inventory.name as inventory_name, inventory.serial_no')
                    ->join('inventory', 'inventory.id = requests.inventory_id', 'left')
                    ->where('requests.user_id', $userId)
                    ->orderBy('requests.created_at', 'DESC')
                    ->findAll();
    }
}
