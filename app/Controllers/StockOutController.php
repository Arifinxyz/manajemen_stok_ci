<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\StockOutModel;

class StockOutController extends BaseController
{
    public function index()
    {
        return view('stock_out/index');
    }

    public function validateBarcode()
    {
        $barcode = $this->request->getGet('barcode');
        $product = (new ProductsModel())->where('product_code', $barcode)->first();

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product not found'
            ]);
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

        $stockOutModel = new StockOutModel();
        $productModel = new ProductsModel();

        foreach ($products as $item) {
            $product = $productModel->find($item['product_id']);

            if (!$product) continue;

            $currentStock = (int)$product['stock'];
            $qtyToSubtract = (int)$item['quantity'];

            // Cegah stock minus
            if ($currentStock < $qtyToSubtract) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Stok tidak cukup untuk produk: ' . $product['name']
                ]);
            }

            // Simpan ke tabel stock_out
            $stockOutModel->insert([
                'product_id' => $item['product_id'],
                'quantity'   => $qtyToSubtract,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // Kurangi stok produk
            $productModel->update($item['product_id'], [
                'stock' => $currentStock - $qtyToSubtract
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'csrfToken' => csrf_hash()
        ]);
    }
}
