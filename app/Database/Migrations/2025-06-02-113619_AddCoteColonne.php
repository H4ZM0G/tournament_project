<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCoteColonne extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tournament', [
            'cote' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tournament', 'cote');
    }
}
