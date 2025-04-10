<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'petugas',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'petugas',
            ],
            [
                'name' => 'hrd',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'hrd',
            ],
            [
                'name' => 'pabrik',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'pabrik',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}