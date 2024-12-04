<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    protected $table = 'school';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name', 'city', 'score','created_at', 'updated_at', 'deleted_at'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

    // Champs de gestion des dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|is_unique[school.name,id,{id}]|min_length[3]|max_length[100]',
        'city' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom d\'ecole est requis.',
            'min_length' => 'Le nom d\'ecole doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom d\'ecole ne doit pas dépasser 100 caractères.',
            'is_unique'   => 'Ce nom d\'ecole est déja utilisé.',
        ],
        'city' => [
            'required'   => 'Le nom de la ville est requis.',
            'min_length' => 'Le nom de la ville doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom de la ville ne doit pas dépasser 100 caractères.',
        ],
    ];

    // Callbacks pour le hachage du mot de passe
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }

    // Relations avec les permissions
    public function getPermissions()
    {
        return $this->join('user_permission', 'user.id_permission = user_permission.id')
            ->select('user.*, user_permission.name as permission_name')
            ->findAll();
    }

    public function getSchoolById($id)
    {
        return $this->find($id);
    }
    public function getAllSchools()
    {
        return $this->findAll();
    }

    public function createSchool($data)
    {
        return $this->insert($data);
    }
    public function updateSchool($id, $data)
    {
        return $this->update($data);
    }
    public function deleteSchool($id)
    {
        return $this->delete($id);
    }

    public function getPaginatedSchool($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->table('school');
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
            $builder->orLike('city', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotalUser()
    {
        $builder = $this->table('school');
        return $builder->countAllResults();
    }

    public function getFilteredUser($searchValue)
    {
        $builder = $this->table('school');
        // @phpstan-ignore-next-line
        if (! empty($searchValue)) {
            $builder->like('name', $searchValue);
            $builder->orLike('city', $searchValue);
        }

        return $builder->countAllResults();
    }
}
