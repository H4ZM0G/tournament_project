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

        $this->db->query('ALTER TABLE user ADD CONSTRAINT fk_id_permission FOREIGN KEY (id_permission) REFERENCES user_permission(id) ON DELETE CASCADE ON UPDATE CASCADE');


    }

    public function down()
    {
        $this->db->query('ALTER TABLE user DROP FOREIGN KEY fk_id_permission');
        $this->forge->dropTable('user_permission');
    }
}
