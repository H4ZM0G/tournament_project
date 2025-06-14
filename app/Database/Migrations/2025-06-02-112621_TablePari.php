<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TablePari extends Migration
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
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_user_participant' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_tournament' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'mise_depart' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'gain' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'date_pari' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user_participant', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_tournament', 'tournament', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pari');
    }
    public function down()
    {
        $this->forge->dropTable('pari');
    }
}
