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
                'name' => 'userAdmin',
                'email' => 'userAdmin@g.c',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'userAdmin',
            ],
            [
                'name' => 'productAdmin',
                'email' => 'productAdmin@g.c',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role'     => 'productAdmin',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}