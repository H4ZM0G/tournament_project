<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableTournamentOpt extends Migration
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
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'value' => [
                'type'       => 'TEXT',
                'constraint' => '255',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tournamentopt');
    }

    public function down()
    {
        //
    }
}
