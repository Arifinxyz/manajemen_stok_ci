<?php

// app/Controllers/StockInController.php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\StockInModel;

class StockInController extends BaseController
{
    public function index()
    {
        requireLogin();
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
                'name' => $product['name']
            ]
        ]);
    }

    public function store()
{
    $data = $this->request->getJSON(true);
    $products = $data['products'] ?? [];

    $stockModel = new \App\Models\StockInModel();
    $productModel = new \App\Models\ProductsModel();

    foreach ($products as $item) {
        // 1. Simpan ke tabel stock_in
        $stockModel->insert([
            'product_id' => $item['product_id'],
            'quantity'   => $item['quantity'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Tambahkan ke stok produk
        $product = $productModel->find($item['product_id']);
        if ($product) {
            $newQty = (int)$product['stock'] + (int)$item['quantity'];
            $productModel->update($item['product_id'], ['stock' => $newQty]);
        }
    }

    return $this->response->setJSON([
        'success' => true,
        'csrfToken' => csrf_hash()
    ]);
}

}
