<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorySchoolModel extends Model
{
    protected $table = 'school_category';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name', 'slug'];

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Le nom de la permission est requis.',
            'min_length' => 'Le nom de la permission doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom de la permission ne doit pas dépasser 100 caractères.',
        ],
    ];

    public function createSchoolCategory($data)
    {
        if (isset($data['name'])) {
            // Générer et vérifier le slug unique
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }

        return $this->insert($data);
    }

    public function updateSchoolCategory($id, $data)
    {
        if (isset($data['name'])) {
            // Générer et vérifier le slug unique
            $data['slug'] = $this->generateUniqueSlug($data['name']);
        }

        return $this->update($id, $data);
    }

    private function generateUniqueSlug($name)
    {
        $slug = generateSlug($name); // Utilisez la fonction du helper pour générer le slug de base
        $builder = $this->builder();

        // Vérifiez si le slug existe déjà
        $count = $builder->where('slug', $slug)->countAllResults();

        if ($count === 0) {
            return $slug;
        }

        // Si le slug existe, ajoutez un suffixe numérique pour le rendre unique
        $i = 1;
        while ($count > 0) {
            $newSlug = $slug . '-' . $i;
            $count = $builder->where('slug', $newSlug)->countAllResults();
            $i++;
        }

        return $newSlug;
    }
    public function getAllCategories()
    {
        return $this->findAll();
    }

    public function getSchoolCategoryById($id)
    {
        return $this->find($id);
    }

    public function deleteSchoolCategory($id)
    {
        return $this->delete($id);
    }

    public function getPaginatedCategory($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        // Recherche
        if ($searchValue != null) {
            $builder->like('name', $searchValue);
        }

        // Tri
        if ($orderColumnName && $orderDirection) {
            $builder->orderBy($orderColumnName, $orderDirection);
        }

        $builder->limit($length, $start);

        return $builder->get()->getResultArray();
    }

    public function getTotalCategory()
    {
        $builder = $this->builder();
        return $builder->countAllResults();
    }

    public function getFilteredCategory($searchValue)
    {
        $builder = $this->builder();
        // @phpstan-ignore-next-line
        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
}