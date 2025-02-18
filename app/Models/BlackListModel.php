<?php
namespace App\Models;

use CodeIgniter\Model;

class BlacklistModel extends Model
{
    protected $table      = 'blacklist';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'created_at'];
    protected $useTimestamps = false;

    // Ajouter un utilisateur à la blacklist
    public function addToBlacklist($id)
    {
        // Vérifie si l'utilisateur est déjà dans la blacklist
        if (!$this->isBlacklisted($id)) {
            $builder = $this->builder();
            return $builder->insert([
                'user_id' => $id,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        return false; // L'utilisateur est déjà dans la blacklist
    }

    // Retirer un utilisateur de la blacklist
    public function removeFromBlacklist($id)
    {
        $builder = $this->builder();
        $builder->where('user_id', $id);
        return $builder->delete();
    }

    // Vérifie si un utilisateur est déjà dans la blacklist
    public function isBlacklisted($id)
    {
        $builder = $this->builder();
        $builder->where('user_id', $id);
        return $builder->countAllResults() > 0;
    }

    public function addToBlacklistuser($userId)
    {
        return $this->insert([
            'user_id' => $userId,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }




}

