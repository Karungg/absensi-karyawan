<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailJadwalAbsenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jabatan' => [
                'type'           => 'INT',
                'constraint'     => 11,
            ],
            'id_jadwal_absen' => [
                'type'           => 'INT',
                'constraint'     => 11,
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
        $this->forge->createTable('detail_jadwal_absen');
    }

    public function down()
    {
        $this->forge->dropTable('detail_jadwal_absen');
    }
}
