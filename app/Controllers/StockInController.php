<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\StockInModel;

class StockInController extends BaseController
{
    public function index()
    {
        return view('stock_in/index');

    }

    public function validateBarcode()
    {
        $barcode = $this->request->getGet('barcode');
        $product = (new ProductsModel())->where('product_code', $barcode)->first();

        if (!$product) {
            return $this->response->setJSON(['success' => false, 'message' => 'Product not found']);
        }

        return $this->response->setJSON([
            'success' => true,
            'product' => [
                'id' => $product['id'],
                'name' => $product['name'],
            ]
        ]);
    }

    public function store()
    {
        $data = $this->request->getJSON(true);
        $products = $data['products'] ?? [];

        $stockModel = new StockInModel();

        foreach ($products as $item) {
            $stockModel->insert([
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'csrfToken' => csrf_hash()
        ]);
    }
}
