<?php

namespace App\Models;

use CodeIgniter\Model;

class SchoolModel extends Model
{
    protected $table            = 'school';
    protected $primaryKey       = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'city', 'score', 'created_at', 'updated_at', 'deleted_at'];

    // Dates
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required|min_length[0]|max_length[100]',
        'city' => 'required|min_length[0]|max_length[100]',
    ];

    protected $validationMessages   = [
        'name' => [
            'required'   => 'Le nom de l\'établissement est requis.',
            'min_length' => 'Le nom de l\'établissement doit comporter au moins 0 caractères.',
            'max_length' => 'Le nom de l\'établissement ne doit pas dépasser 100 caractères.',

        ],
        'city' => [
            'required'   => 'Le nom de la ville est requis.',
            'min_length' => 'Le nom de la ville doit comporter au moins 0 caractères.',
            'max_length' => 'Le nom de la ville ne doit pas dépasser 100 caractères.',

        ],
    ];
    public function getAllSchool() {
        $builder = $this->db->table('school s');

        $builder->select("s.id, s.name, s.city, s.score, s.created_at, s.updated_at, s.deleted_at");

        $builder->orderBy('s.id', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function getschoolById($id) {
        return $this->find($id);
    }

    public function deleteSchool($id) {
        return $this->delete($id);
    }

    public function updateSchool($id, $data) {
        return $this->update($id, $data);
    }

}
