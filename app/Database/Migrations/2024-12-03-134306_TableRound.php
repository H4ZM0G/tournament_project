<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableRound extends Migration
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
            'id_u_1' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_u_2' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_winner' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_tournament' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_u_1', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_u_2', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_winner', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_tournament', 'tournament', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('round');

    }

    public function down()
    {
        $this->forge->dropTable('round');
    }
}
