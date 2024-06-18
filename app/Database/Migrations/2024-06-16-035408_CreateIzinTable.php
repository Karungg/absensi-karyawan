<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIzinTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_izin' => [
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
                'constraint' => '11',
            ],
            'tgl_izin' => [
                'type'       => 'DATE'
            ],
            'alasan' => [
                'type'       => 'TEXT',
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
        $this->forge->addKey('id_izin', true);
        $this->forge->createTable('izin');
    }

    public function down()
    {
        $this->forge->dropTable('izin');
    }
}
