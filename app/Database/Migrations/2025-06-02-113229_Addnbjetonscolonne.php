<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addnbjetonscolonne extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
            'nb_jetons' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 200,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'nb_jetons');
    }
}
