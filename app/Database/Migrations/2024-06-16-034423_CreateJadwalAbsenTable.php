<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalAbsenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal_absen' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jadwal' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
            ],
            'jam_masuk' => [
                'type'       => 'TIME',
            ],
            'batas_jam_masuk' => [
                'type'       => 'TIME',
            ],
            'jam_pulang' => [
                'type'       => 'TIME',
            ],
            'batas_jam_pulang' => [
                'type'       => 'TIME',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id_jadwal_absen', true);
        $this->forge->createTable('jadwal_absen');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal_absen');
    }
}
