<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductsModel;
use App\Models\StockOutModel;

class StockOutController extends BaseController
{
    public function index()
    {
        requireLogin();
        
        if (!petugasRole()) {
            return redirect()->to('/products')->with('error', 'Kamu Tidak Memiliki Akses');
        }
        
        return view('stock_out/index');

    }


    public function data()
    {
        requireLogin();
    
        $stockModel = new StockOutModel();
    
        $month = $this->request->getGet('month') ?? '';
        $year = $this->request->getGet('year') ?? '';
    
        $query = $stockModel->select('stock_out.*, products.name as product_name')
            ->join('products', 'products.id = stock_out.product_id');
    
        if (!empty($month)) {
            $query->where('MONTH(stock_out.created_at)', $month);
        }
        if (!empty($year)) {
            $query->where('YEAR(stock_out.created_at)', $year);
        }
    
        $data['stock_out'] = $query->paginate(10);
        $data['pager'] = $stockModel->pager;
    
        $data['month'] = $month;
        $data['year'] = $year;
    
        return view('stock_out/data', $data);
    }
    
    public function print($month = null, $year = null)
{
    requireLogin();

    $stockModel = new StockOutModel();

    // Query data berdasarkan filter
    $query = $stockModel->select('stock_out.*, products.name as product_name')
        ->join('products', 'products.id = stock_out.product_id');

    if ($month) {
        $query->where('MONTH(stock_out.created_at)', $month);
    }
    if ($year) {
        $query->where('YEAR(stock_out.created_at)', $year);
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
    header('Content-Disposition: attachment;filename="StockOut_Report.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
}

public function filter()
{
    requireLogin();

    $stockModel = new StockOutModel();

    // Ambil filter bulan dan tahun dari request
    $month = $this->request->getVar('month');
    $year = $this->request->getVar('year');

    // Query data berdasarkan filter
    $query = $stockModel->select('stock_out.*, products.name as product_name')
        ->join('products', 'products.id = stock_out.product_id');

    // Tambahkan kondisi hanya jika bulan atau tahun tidak kosong
    if (!empty($month)) {
        $query->where('MONTH(stock_out.created_at)', $month);
    }
    if (!empty($year)) {
        $query->where('YEAR(stock_out.created_at)', $year);
    }

    // Jika tidak ada filter, kembalikan semua data
    $data['stock_out'] = $query->findAll();

    return $this->response->setJSON(['stock_out' => $data['stock_out']]);
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
