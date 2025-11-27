<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatTables extends Migration
{
    public function up()
    {
        // chats table
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'division'    => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Finance'],
            'user_name'   => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'status'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'open'],
            'assigned'    => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => false],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('chats', true);

        // messages table
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'chat_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'sender'     => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'user'],
            'text'       => ['type' => 'TEXT', 'null' => true],
            'attachments'=> ['type' => 'TEXT', 'null' => true],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'sent'],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('chat_id');
        $this->forge->createTable('messages', true);
    }

    public function down()
    {
        $this->forge->dropTable('messages', true);
        $this->forge->dropTable('chats', true);
    }
}
