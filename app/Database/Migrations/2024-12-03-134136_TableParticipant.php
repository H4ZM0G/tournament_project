<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableParticipant extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_tournament' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_tournament', 'tournament', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('participant');
    }

    public function down()
    {
        $this->forge->dropTable('participant');
    }
}
