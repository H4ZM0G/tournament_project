<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableUserPermission extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user_permission');

        // Insérer les 3 permissions par défaut
        $data = [
            ['name' => 'Administrateur'],
            ['name' => 'Collaborateur'],
            ['name' => 'Utilisateur'],
        ];
        $this->db->table('user_permission')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('user_permission');
    }
}
