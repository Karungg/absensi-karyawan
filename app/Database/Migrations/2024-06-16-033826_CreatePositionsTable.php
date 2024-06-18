<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePositionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jabatan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
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
        $this->forge->addKey('id_jabatan', true);
        $this->forge->createTable('jabatan');
    }

    public function down()
    {
        $this->forge->dropTable('jabatan');
    }
}
