<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table = 'participant';
    protected $primaryKey = 'id';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['id_user', 'id_tournament', 'created_at', 'updated_at'];

    // Activer le soft delete
    protected $useSoftDeletes = true;

    // Champs de gestion des dates
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'id_user' => 'required|is_natural_no_zero',
        'id_tournament' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'id_user' => [
            'required' => 'L\'utilisateur est requis.',
            'is_natural_no_zero' => 'L\'ID de l\'utilisateur doit être un entier positif.',
        ],
        'id_tournament' => [
            'required' => 'Le tournoi est requis.',
            'is_natural_no_zero' => 'L\'ID du tournoi doit être un entier positif.',
        ],
    ];

    // Méthodes personnalisées

    public function createParticipant($data)
    {
        return $this->insert($data);
    }

    public function deleteParticipant($id)
    {
        return $this->delete($id);
    }

    public function getParticipantsWithDetails()
    {
        $builder = $this->builder();
        $builder->join('tournament', 'participant.id_tournament = tournament.id', 'left');
        $builder->join('user', 'participant.id_user = user.id', 'left');
        $builder->select('participant.*, tournament.name as tournament_name, user.username as user_name');

        return $builder->get()->getResultArray();
    }
}