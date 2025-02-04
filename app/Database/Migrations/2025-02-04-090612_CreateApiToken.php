<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateApiToken extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'counter' => [
                'type' => 'INT',
                'default' => 10,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('api_token');

    }

    public function down()
    {
        $this->forge->dropTable('api_token');
    }
}
