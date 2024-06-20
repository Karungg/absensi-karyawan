<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHariLiburTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_hari_libur' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_jadwal_absen' => [
                'type'       => 'INT',
                'constraint' => '11',
            ],
            'nama_hari_libur' => [
                'type'       => 'VARCHAR',
                'constraint'       => '50',
            ],
            'keterangan' => [
                'type'       => 'TEXT',
            ],
            'tgl_hari_libur' => [
                'type'       => 'DATE',
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
        $this->forge->addKey('id_hari_libur', true);
        $this->forge->createTable('hari_libur');
    }

    public function down()
    {
        $this->forge->dropTable('hari_libur');
    }
}
