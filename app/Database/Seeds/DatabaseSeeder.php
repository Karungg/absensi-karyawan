<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            ['name' => 'admin'],
            ['name' => 'user'],
        ];

        $groupsUsers = [
            'group_id' => 1,
            'user_id' => 1
        ];

        $jabatan = [
            [
                'nama_jabatan' => 'Direktur',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama_jabatan' => 'Manager',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama_jabatan' => 'Karyawan',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama_jabatan' => 'Security',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
            [
                'nama_jabatan' => 'Operator',
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ],
        ];

        // Insert groups
        $this->db->table('auth_groups')->insertBatch($groups);

        // Insert jabatan
        $this->db->table('jabatan')->insertBatch($jabatan);

        // Insert user
        $userId = $this->db->table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => '$2y$10$kdmqKVODrwuuVYD1x4Tmpew4I/A7boI.0nOX47SbRUClPjZigdehG', //password
            'active' => 1,
            'id_jabatan' => 5,
            'created_at' => Time::now(),
            'updated_at' => Time::now()
        ]);

        // Insert groups user
        $this->db->table('auth_groups_users')->insert([
            'group_id' => 1,
            'user_id' => 1
        ]);
    }
}
