<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableQualification extends Migration
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
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'TINYINT',
                'unsigned' => true,
                'comment' => '0: En attente, 1: Qualifié, 2: Éliminé',
            ],
            'libelle_status' => [
                'type'       => 'ENUM',
                'constraint' => ['En attente', 'Qualifié', 'Éliminé'],
                'default'    => 'En attente',
            ],
            'id_tournament' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_tournament', 'tournament', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('qualification');
    }

    public function down()
    {
        $this->forge->dropTable('qualification', true);
    }
}
