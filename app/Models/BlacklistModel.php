<?php

namespace App\Models;

use CodeIgniter\Model;

class BlacklistModel extends Model
{
    protected $table = 'blacklist';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $protectFields = true;
    protected $allowedFields = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    public function activateUserBlacklisted($id)
    {

        $builder = $this->builder();
        return $builder->insert([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function deleteUserBlacklisted($id)
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
