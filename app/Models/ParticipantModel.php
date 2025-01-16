<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table = 'participant';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['id_tournament' ,'id_user'];

    // Activer le soft delete
    protected $useSoftDeletes = true;


    // Validation
    protected $validationRules = [
        'id_tournament' => 'required|is_natural_no_zero',
        'id_user' => 'required|is_natural_no_zero',

    ];
    protected $validationMessages = [
        'id_tournament' => [
            'required' => 'L\'identifiant du tournois est requis.',
            'is_natural_no_zero' => 'L\'identifiant du jeu doit être un entier positif non nul.',
        ],
        'id_user' => [
            'required' => 'L\'identifiant du l\'utilisateur est requis.',
            'is_natural_no_zero' => 'L\'identifiant du jeu doit être un entier positif non nul.',
        ],
    ];

    // Méthodes personnalisées

    public function getTournamentById($id)
    {
        $this->select('tournament.*, media.file_path as avatartournament_url');
        $this->join('media', 'tournament.id = media.entity_id AND media.entity_type = "tournament"', 'left');
        return $this->find($id);
    }

    public function updateParticipant($id, $data)
    {
        $builder = $this->builder();
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteParticipant($id)
    {
        return $this->delete($id);
    }

    public function countParticipant()
    {
        return $this->countAllResults();
    }

    public function getPaginatedParticipants($start, $length, $searchValue, $orderColumnName, $orderDirection)
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

    public function getFilteredParticipants($searchValue)
    {
        $builder = $this->builder();
        $builder->join('tournament', 'participant.id_tournament = tournament.id', 'left');
        $builder->join('user', 'participant.id_user = user.id', 'left');
        $builder->select('participant.*');

        if (!empty($searchValue)) {
            $builder->like('name', $searchValue);
        }

        return $builder->countAllResults();
    }
    public function getAllParticipants() {
        $builder = $this->db->table('Participant p');

        $builder->select("p.id_tournament, p.id_user");

        return $builder->get()->getResultArray();
    }

    public function getProductById($id) {
        return $this->find($id);
    }
}
