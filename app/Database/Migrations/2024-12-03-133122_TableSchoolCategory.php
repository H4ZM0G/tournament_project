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

            ['name' => 'Non Classée'],
            ['name' => 'Lycée'],
            ['name' => 'FAC'],
            ['name' => 'CFA'],
            ['name' => 'École Privée'],
        ];
        $this->db->table('school_category')->insertBatch($data);

        $trigger_sql = "
            CREATE TRIGGER prevent_delete_initial_school_category
            BEFORE DELETE ON school_category
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La suppression de la categorie \"Non classé\" est interdite.';
                END IF;
            END;
        ";
        $this->db->query($trigger_sql);
    }


    public function down()
    {
        $this->forge->dropTable('school_category');
    }

}
