<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnRoleOnTableUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['petugas', 'userAdmin', 'productAdmin'],
                'after' => 'password',
                null => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'role');
    }
}
