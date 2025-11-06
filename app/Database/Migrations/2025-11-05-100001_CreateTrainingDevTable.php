<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTrainingDevTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'duration' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'instructor' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'Scheduled',
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
        $this->forge->createTable('training_dev');
    }

    public function down()
    {
        $this->forge->dropTable('training_dev');
    }
}

