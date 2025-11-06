<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonalAdminTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'divisi' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'Active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('personal_admin');
    }

    public function down()
    {
        $this->forge->dropTable('personal_admin');
    }
}

