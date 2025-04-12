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
    public function data()
    {
        requireLogin();
    
        $stockModel = new StockInModel();
    
        $month = $this->request->getGet('month') ?? '';
        $year = $this->request->getGet('year') ?? '';
    
        $query = $stockModel->select('stock_in.*, products.name as product_name')
            ->join('products', 'products.id = stock_in.product_id');
    
        if (!empty($month)) {
            $query->where('MONTH(stock_in.created_at)', $month);
        }
        if (!empty($year)) {
            $query->where('YEAR(stock_in.created_at)', $year);
        }
    
        $data['stock_in'] = $query->paginate(10);
        $data['pager'] = $stockModel->pager;
    
        $data['month'] = $month;
        $data['year'] = $year;
    
        return view('stock_in/data', $data);
    }
    
    public function print($month = null, $year = null)
{
    requireLogin();

    $stockModel = new StockInModel();

    // Query data berdasarkan filter
    $query = $stockModel->select('stock_in.*, products.name as product_name')
        ->join('products', 'products.id = stock_in.product_id');

    if ($month) {
        $query->where('MONTH(stock_in.created_at)', $month);
    }
    if ($year) {
        $query->where('YEAR(stock_in.created_at)', $year);
    }

    $stock_in = $query->findAll();

    // Load PhpSpreadsheet
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set Header
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Product Name');
    $sheet->setCellValue('C1', 'Quantity');
    $sheet->setCellValue('D1', 'Date');

    // Set Data
    $row = 2;
    foreach ($stock_in as $item) {
        $sheet->setCellValue('A' . $row, $item['id']);
        $sheet->setCellValue('B' . $row, $item['product_name']);
        $sheet->setCellValue('C' . $row, $item['quantity']);
        $sheet->setCellValue('D' . $row, $item['created_at']);
        $row++;
    }

    // Set Header untuk Download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="StockIn_Report.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}

public function filter()
{
    requireLogin();

    $stockModel = new StockInModel();

    // Ambil filter bulan dan tahun dari request
    $month = $this->request->getVar('month');
    $year = $this->request->getVar('year');

    // Query data berdasarkan filter
    $query = $stockModel->select('stock_in.*, products.name as product_name')
        ->join('products', 'products.id = stock_in.product_id');

    // Tambahkan kondisi hanya jika bulan atau tahun tidak kosong
    if (!empty($month)) {
        $query->where('MONTH(stock_in.created_at)', $month);
    }
    if (!empty($year)) {
        $query->where('YEAR(stock_in.created_at)', $year);
    }

    // Jika tidak ada filter, kembalikan semua data
    $data['stock_in'] = $query->findAll();

    return $this->response->setJSON(['stock_in' => $data['stock_in']]);
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
