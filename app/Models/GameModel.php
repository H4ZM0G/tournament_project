<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table = 'game';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name', 'id_category', 'created_at', 'updated_at', 'deleted_at'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

    // Champs de gestion des dates
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'id_category' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Le nom du jeu est requis.',
            'min_length' => 'Le nom du jeu doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom du jeu ne doit pas dépasser 255 caractères.',
        ],
        'id_category' => [
            'required' => 'La catégorie est requise.',
            'is_natural_no_zero' => 'La catégorie doit être un entier positif.',
        ],
    ];

    // Méthodes personnalisées

    public function getGamesWithMedia()
    {
        $builder = $this->builder();
        $builder->join('media', 'game.id = media.entity_id AND media.entity_type = "game"', 'left');
        $builder->select('game.*, media.file_path as avatargame_url');


        return $builder->get()->getResultArray();
    }
    public function getGamesWithMediaFront()
    {
        $builder = $this->builder();
        $builder->join('media', 'game.id = media.entity_id AND media.entity_type = "game"', 'left');
        $builder->select('game.*, media.file_path as avatargame_url');
        $builder->where('game.deleted_at', null); // Filtre pour les jeux actifs


        return $builder->get()->getResultArray();
    }

    public function getGameById($id)
    {
        $this->select('game.*, media.file_path as avatar_url');
        $this->join('media', 'game.id = media.entity_id AND media.entity_type = "game"', 'left');
        return $this->find($id);
    }

    public function createGame($data)
    {
        return $this->insert($data);
    }

    public function activateGame($id)
    {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function updateGame($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteGame($id)
    {
        return $this->delete($id);
    }

    public function countGames()
    {
        return $this->countAllResults();
    }

    public function getPaginatedGames($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        $builder->join('media', 'game.id = media.entity_id AND media.entity_type = "game"', 'left');
        $builder->select('game.*, media.file_path as avatar_url');

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

    public function getTotalGames()
    {
        return $this->countAllResults();
    }

    public function getFilteredGames($searchValue)
    {
        $builder = $this->builder();
        $builder->join('media', 'game.id = media.entity_id AND media.entity_type = "game"', 'left');
        $builder->select('game.*,  media.file_path as avatar_url');

        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }

    public function getGameTitleOnly($id){
        return $this->find($id)['name'];
    }

    public function getAllGamesTitleOnly(){
        $this->select('game.name, game_category.name as category');
        $this->join('game_category', 'game.id_category = game_category.id', 'left');
        return $this->findAll();
    }
}
