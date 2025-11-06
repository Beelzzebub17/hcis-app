<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataValidationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'check_item' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'total' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'Pending',
            ],
            'last_check' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->createTable('data_validation');
    }

    public function down()
    {
        $this->forge->dropTable('data_validation');
    }
}

