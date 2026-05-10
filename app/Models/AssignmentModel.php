<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * HAFTA 4 — Öğrenci 4
 * Zimmet (Assignment) modeli
 */
class AssignmentModel extends Model
{
    protected $table            = 'assignments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    protected $allowedFields = [
        'user_id',
        'inventory_id',
        'request_id',
        'approved_by',
        'assigned_at',
        'returned_at',
        'notes',
    ];

    protected $validationRules = [
        'user_id'      => 'required|integer',
        'inventory_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'Kullanıcı bilgisi gereklidir.',
            'integer'  => 'Geçersiz kullanıcı.',
        ],
        'inventory_id' => [
            'required' => 'Envanter bilgisi gereklidir.',
            'integer'  => 'Geçersiz envanter.',
        ],
    ];

    /**
     * Tüm zimmet kayıtlarını kullanıcı ve envanter bilgileriyle birlikte getirir.
     */
    public function getAssignmentsWithDetails()
    {
        return $this->select('assignments.*, inventory.name as inventory_name, inventory.serial_no, inventory.brand, users.username as staff_name')
                    ->join('inventory', 'inventory.id = assignments.inventory_id', 'left')
                    ->join('users', 'users.id = assignments.user_id', 'left')
                    ->orderBy('assignments.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Tek bir zimmet kaydını detaylarıyla getirir.
     */
    public function getAssignmentWithDetails($id)
    {
        return $this->select('assignments.*, inventory.name as inventory_name, inventory.serial_no, inventory.brand, inventory.status as inventory_status, users.username as staff_name, approver.username as approver_name')
                    ->join('inventory', 'inventory.id = assignments.inventory_id', 'left')
                    ->join('users', 'users.id = assignments.user_id', 'left')
                    ->join('users as approver', 'approver.id = assignments.approved_by', 'left')
                    ->where('assignments.id', $id)
                    ->first();
    }
}
