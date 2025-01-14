<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTournamentName extends Migration
{
    public function up()
    {
        // Ajoute une colonne 'name' à la table 'tournament'
        $this->forge->addColumn('tournament', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false, // Rendre le champ obligatoire
                'unique'     => true, // Si nécessaire
                'after'      => 'id', // Ajouter après la colonne 'id'
            ],
        ]);
    }

    public function down()
    {
        // Supprime la colonne 'name' de la table 'tournament'
        $this->forge->dropColumn('tournament', 'name');
    }
}