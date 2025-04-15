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
                'email' => 'petugas@g.c',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'petugas',
            ],
            [
                'name' => 'hrd',
                'email' => 'hrd@g.c',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'hrd',
            ],
            [
                'name' => 'pabrik',
                'email' => 'pabrik@g.c',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'pabrik',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}