<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected CategoryModel $categories;

    public function __construct()
    {
        $this->categories = new CategoryModel();
    }

    /**
     * List all categories. Route: GET /admin/categories
     */
    public function index()
    {
        return view('admin/categories/index', [
            'categories' => $this->categories->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    /**
     * Show the "new category" form. Route: GET /admin/categories/create
     */
    public function create()
    {
        return view('admin/categories/create');
    }

    public function store()
{
    $valid = $this->validate([
        'name' => 'required|min_length[2]|max_length[255]|is_unique[categories.name]',
        'description' => 'permit_empty|max_length[500]'
    ]);

    if (! $valid) {
        return redirect()->back()
                         ->withInput()
                         ->with('errors', $this->validator->getErrors());
    }

    $this->categories->insert([
        'name'        => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
    ]);

    return redirect()->to('/admin/categories')->with('success', 'Eklendi.');
}

    public function edit($id)
    {
        $category = $this->categories->find($id);

        if($category == null){
            return redirect()->to('/admin/categories')->with('error', 'Kategori bulunamadı.');
        }

        return view('/admin/categories/edit',
        ['category' => $category]
        );
    }

    public function update($id)
    {
        $category = $this->categories->find($id);
        if ($category === null) {
        return redirect()->to('/admin/categories')->with('error', 'Kategori bulunamadı.');}

        $valid = $this->validate([
        'name' => "required|min_length[2]|max_length[255]|is_unique[categories.name,id,{$id}]", //ignore itself when checking for uniqueness
        'description' => 'permit_empty|max_length[500]']);

        if (! $valid) {
        // Send them back to the form with their typing (withInput) and the errors
        return redirect()->back()->withInput()->with('error', 'Girilen değerler geçerli değil');}

        $this->categories->update($id, [
        'name'        => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
    ]);
    }

    public function delete($id)
    {
        // TODO: delete (soft delete? hard?), redirect
        // Edge case worth thinking about: what happens to inventory items
        // whose category_id points to a category you're deleting?
        // Options: cascade delete, prevent delete if any FK refs, nullify.
        // Per lazim.md you only own categories table — think about this before picking.
        return redirect()->to('/admin/categories')->with('error', 'delete() not implemented');
    }
}