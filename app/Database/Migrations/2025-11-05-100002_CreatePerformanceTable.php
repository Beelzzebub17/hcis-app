<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePerformanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'employee_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'employee_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'period' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'score' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0.00,
            ],
            'rating' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('performance');
    }

    public function down()
    {
        $this->forge->dropTable('performance');
    }
}

