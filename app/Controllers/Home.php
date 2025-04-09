<?php

namespace App\Controllers;

use App\Models\StockInModel;
use App\Models\ProductsModel;
use App\Models\StockOutModel;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index()
{
    $productModel = new ProductsModel();
    $stockInModel = new StockInModel();
    $stockOutModel = new StockOutModel();

    $productCount = $productModel->countAll();

    // Jumlah selama 1 bulan terakhir
    $startDate = date('Y-m-d 00:00:00', strtotime('-1 month'));
    $endDate   = date('Y-m-d 23:59:59');
    
    $stockIn = $stockInModel
        ->where('created_at >=', $startDate)
        ->where('created_at <=', $endDate)
        ->selectSum('quantity')
        ->first();

    $stockOut = $stockOutModel
        ->where('created_at >=', $startDate)
        ->where('created_at <=', $endDate)
        ->selectSum('quantity')
        ->first();

    // Statistik 12 bulan terakhir
    $monthlyStockIn = [];
    $monthlyStockOut = [];

    for ($i = 11; $i >= 0; $i--) {
        $monthStart = date('Y-m-01 00:00:00', strtotime("-$i months"));
        $monthEnd   = date('Y-m-t 23:59:59', strtotime("-$i months"));
        $monthLabel = date('M Y', strtotime("-$i months"));

        $in = $stockInModel
            ->where('created_at >=', $monthStart)
            ->where('created_at <=', $monthEnd)
            ->selectSum('quantity')
            ->first();

        $out = $stockOutModel
            ->where('created_at >=', $monthStart)
            ->where('created_at <=', $monthEnd)
            ->selectSum('quantity')
            ->first();

        $monthlyStockIn[] = [
            'month' => $monthLabel,
            'total' => (int)($in['quantity'] ?? 0)
        ];

        $monthlyStockOut[] = [
            'month' => $monthLabel,
            'total' => (int)($out['quantity'] ?? 0)
        ];
    }

    return view('index', [
        'productCount' => $productCount,
        'stockInTotal' => $stockIn['quantity'] ?? 0,
        'stockOutTotal' => $stockOut['quantity'] ?? 0,
        'monthlyStockIn' => $monthlyStockIn,
        'monthlyStockOut' => $monthlyStockOut,
    ]);
}

    
}
