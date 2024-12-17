<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableTournament extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_game' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'constraint'     => 11,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_game', 'game', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tournament');
    }

    public function down()
    {
        $this->forge->dropTable('tournament');
    }
}
