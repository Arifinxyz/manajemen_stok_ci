<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use CodeIgniter\HTTP\ResponseInterface;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductsModel();
        $products = $productModel->findAll();
    
        foreach ($products as &$product) {
            $generator = new BarcodeGeneratorPNG();
            $product['barcode'] = base64_encode($generator->getBarcode($product['product_code'], $generator::TYPE_CODE_128));
        }
    
        return view('products/index', ['products' => $products]);
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
    
    public function update($id)
    {
        $model = new ProductsModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'product_code' => $this->request->getVar('product_code'),
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
