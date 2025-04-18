<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stock_in extends Migration
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
            'product_id' => [
                'type' => 'int',
                'constraint' => 12,
                'unsigned' => true
            ],
            'quantity' => [
                'type' => 'int',
                'constraint' => 12,
                'unsigned' => true
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable(table: 'stock_in');

    }

    public function down()
    {
        $this->forge->dropTable('stock_in');
    }
}
