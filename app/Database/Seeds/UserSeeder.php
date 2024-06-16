<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => '$2y$10$kdmqKVODrwuuVYD1x4Tmpew4I/A7boI.0nOX47SbRUClPjZigdehG', //password
            'active' => 1
        ]);
    }
}
