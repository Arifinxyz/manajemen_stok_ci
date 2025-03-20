<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 12,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'product_code' => [
                'type' => 'varchar',
                'constraint' => 100
            ],
            'name' => [
                'type' => 'varchar',
                'constraint' => 100
            ],
            'stock' => [
                'type' => 'int',
                'constraint' => '12',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);

        // Tambahkan primary key
        $this->forge->addKey('id', true);

        // Buat tabel
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}