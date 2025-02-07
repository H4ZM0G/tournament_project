<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableBlacklist extends Migration
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('blacklist');

    }

    public function down()
    {
        $this->forge->dropTable('blacklist');
    }
}
