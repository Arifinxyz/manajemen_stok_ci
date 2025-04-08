<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['product_code' => '111111111', 'name' => 'Product 1', 'stock' => 50],
            ['product_code' => '222222222', 'name' => 'Product 2', 'stock' => 30],
            ['product_code' => '333333333', 'name' => 'Product 3', 'stock' => 70],
            ['product_code' => '444444444', 'name' => 'Product 4', 'stock' => 20],
            ['product_code' => '555555555', 'name' => 'Product 5', 'stock' => 90],
            ['product_code' => '666666666', 'name' => 'Product 6', 'stock' => 40],
            ['product_code' => '777777777', 'name' => 'Product 7', 'stock' => 60],
            ['product_code' => '888888888', 'name' => 'Product 8', 'stock' => 80],
            ['product_code' => '999999999', 'name' => 'Product 9', 'stock' => 10],
            ['product_code' => '101010101', 'name' => 'Product 10', 'stock' => 100],
            ['product_code' => '121212121', 'name' => 'Product 11', 'stock' => 55],
            ['product_code' => '131313131', 'name' => 'Product 12', 'stock' => 35],
            ['product_code' => '141414141', 'name' => 'Product 13', 'stock' => 75],
            ['product_code' => '151515151', 'name' => 'Product 14', 'stock' => 25],
            ['product_code' => '161616161', 'name' => 'Product 15', 'stock' => 95],
            ['product_code' => '171717171', 'name' => 'Product 16', 'stock' => 45],
            ['product_code' => '181818181', 'name' => 'Product 17', 'stock' => 65],
            ['product_code' => '191919191', 'name' => 'Product 18', 'stock' => 85],
            ['product_code' => '202020202', 'name' => 'Product 19', 'stock' => 15],
            ['product_code' => '212121212', 'name' => 'Product 20', 'stock' => 105],
        ];

        // Insert data ke tabel products
        $this->db->table('products')->insertBatch($data);
    }
}
