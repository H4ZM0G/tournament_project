<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cities extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>true,
                'auto_increment'=>true,
            ],
            'zip_code'=>[
                'type'=>'INT',
                'constraint'=>5,
            ],
            'label'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
            'department_name'=>
                [
                    'type'=>'VARCHAR',
                    'constraint'=>255,
                ],
            "department_number"=>[
                'type'=>'VARCHAR',
                'constraint'=>3,
            ],
            'region_name'=>[
                'type'=>'VARCHAR',
                'constraint'=>255,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addkey('zip_code');
        $this->forge->addkey('label');
        $this->forge->createTable('city');
    }
    public function down()
    {
        $this->forge->dropTable('city');
    }
}
