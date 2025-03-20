<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
            'name' => [
                'type' => 'varchar',
                'constraint' => 100
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => 255
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('Users');
    }

    public function down()
    {
$this->forge->dropTable('users');
    
    }
}