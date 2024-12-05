<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TableSchoolCategory extends Migration
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
        $this->forge->createTable('school_category');

        // Insérer les 3 permissions par défaut
        $data = [
            ['name' => 'Lycée'],
            ['name' => 'FAC'],
            ['name' => 'CFA'],
            ['name' => 'École Privée'],
        ];
        $this->db->table('school_category')->insertBatch($data);

    }


    public function down()
    {
        $this->forge->dropTable('school_category');
    }

}
