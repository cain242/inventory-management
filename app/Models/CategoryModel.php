<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;

    // Columns from CreateCategoriesTable migration (id + timestamps handled automatically)
    protected $allowedFields = ['name', 'description'];

    // TODO (you): validation rules — minimum: name is required, unique, max 255
    // docs: https://codeigniter.com/user_guide/models/model.html#in-model-validation
    protected $validationRules = [];
    protected $validationMessages = [];
}