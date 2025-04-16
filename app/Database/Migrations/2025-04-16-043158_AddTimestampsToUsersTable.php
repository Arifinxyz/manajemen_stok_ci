<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'after'   => 'role' // Tambahkan setelah kolom 'role'
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'after'   => 'created_at'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['created_at', 'updated_at']);
    }
}
