<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\ResponseInterface;

class Products extends BaseController
{
    public function index()
    {
        $model = new ProductsModel();
        $data['products'] = $model->findAll();
        return view('products/index', $data);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $model = new ProductsModel();
        $data = [
            'product_code' => $this->request->getVar('product_code'),
            'name' => $this->request->getVar('name'),
            'stock' => $this->request->getVar('stock'),
        ];
        $model->insert($data);
        return redirect()->to('/products');
    }
    public function edit($id)
    {
        $model = new ProductsModel();
        $data['product'] = $model->find($id);
        return view('products/edit', $data);
    }
    
    public function update($id)
    {
        $model = new ProductsModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'price' => $this->request->getVar('price'),
            'stock' => $this->request->getVar('stock'),
        ];
        $model->update($id, $data);
        return redirect()->to('/products');
    }
    
    public function delete($id)
    {
        $model = new ProductsModel();
        $model->delete($id);
        return redirect()->to('/products');
    }
}
