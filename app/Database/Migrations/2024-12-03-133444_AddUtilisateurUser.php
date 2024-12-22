<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUtilisateurUser extends Migration
{
    public function up()
    {
        // Insérer un utilisateur administrateur par défaut
        $data = [
            'username'     => 'user',
            'name'         => 'user',
            'firstname'    => 'user',
            'email'        => 'user@user.fr',
            'password'     => password_hash('123456789', PASSWORD_DEFAULT),
            'id_permission' => 2, // Id de la permission Administrateur
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        $this->db->table('user')->insert($data);
    }

    public function down()
    {
        $this->db->table('user')
            ->where('username', 'user')
            ->delete();
    }
}

