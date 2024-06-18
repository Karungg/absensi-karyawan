<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_absensi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'id_jadwal_absen' => [
                'type'       => 'INT',
                'constraint'       => '11',
            ],
            'tgl_absen' => [
                'type'       => 'DATE',
            ],
            'absen_masuk' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
            ],
            'absen_pulang' => [
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
        $this->forge->addKey('id_absensi', true);
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
