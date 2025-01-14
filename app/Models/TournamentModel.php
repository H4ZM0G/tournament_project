<?php

namespace App\Models;

use CodeIgniter\Model;

class TournamentModel extends Model
{
    protected $table = 'tournament';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['name' ,'id_game', 'nb_player', 'date_start', 'date_end', 'created_at', 'updated_at', 'deleted_at'];

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
        'id_game' => 'required|is_natural_no_zero',
        'nb_player' => 'required|is_natural|less_than_equal_to[100]|greater_than_equal_to[0]',
        'date_start' => 'required|is_natural_no_zero',
        'date_end' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Le nom du jeu est requis.',
            'min_length' => 'Le nom du jeu doit comporter au moins 3 caractères.',
            'max_length' => 'Le nom du jeu ne doit pas dépasser 255 caractères.',
        ],
        'id_game' => [
            'required' => 'La catégorie est requise.',
            'is_natural_no_zero' => 'La catégorie doit être un entier positif.',
        ],
    ];

    // Méthodes personnalisées

    public function getTournamentsWithMedia()
    {
        $builder = $this->builder();
        $builder->join('media', 'tournament.id = media.entity_id AND media.entity_type = "tournament"', 'left');
        $builder->select('tournament.*, media.file_path as avatartournament_url');


        return $builder->get()->getResultArray();
    }

    public function getTournamentById($id)
    {
        $this->select('tournament.*, media.file_path as avatartournament_url');
        $this->join('media', 'tournament.id = media.entity_id AND media.entity_type = "tournament"', 'left');
        return $this->find($id);
    }

    public function createTournament($data)
    {
        return $this->insert($data);
    }

    public function activateTournament($id)
    {
        $builder = $this->builder();
        $builder->set('deleted_at', NULL);
        $builder->where('id', $id);
        return $builder->update();
    }

    public function updateTournament($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteTournament($id)
    {
        return $this->delete($id);
    }

    public function countTournaments()
    {
        return $this->countAllResults();
    }

    public function getPaginatedTournaments($start, $length, $searchValue, $orderColumnName, $orderDirection)
    {
        $builder = $this->builder();
        $builder->join('media', 'tournament.id = media.entity_id AND media.entity_type = "tournament"', 'left');
        $builder->select('tournament.*, media.file_path as avatartournament_url');

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

    public function getTotalTournaments()
    {
        return $this->countAllResults();
    }

    public function getFilteredTournaments($searchValue)
    {
        $builder = $this->builder();
        $builder->join('media', 'tournament.id = media.entity_id AND media.entity_type = "tournament"', 'left');
        $builder->select('tournament.*,  media.file_path as avatartournament_url');

        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }

}
