<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table = 'participant';
    protected $returnType = 'array';

    protected $allowedFields = ['id_user', 'id_tournament'];

    protected $validationRules = [
        'id_user' => 'required|is_natural_no_zero',
        'id_tournament' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'id_user' => [
            'required' => 'L\'ID de l\'utilisateur est requis.',
            'is_natural_no_zero' => 'L\'ID de l\'utilisateur doit être un entier positif.',
        ],
        'id_tournament' => [
            'required' => 'L\'ID du tournoi est requis.',
            'is_natural_no_zero' => 'L\'ID du tournoi doit être un entier positif.',
        ],
    ];

    public function getParticipantsWithTournamentInfo($id_tournament)
    {
        $query = $this->db->table($this->table)
            ->select('participant.*, user.*, tournament.*')
            ->join('user', 'participant.id_user = user.id')
            ->join('tournament', 'participant.id_tournament = tournament.id')
            ->where('participant.id_tournament', $id_tournament)
            ->get();

        return $query->getResultArray();
    }

//    public function removeParticipant($id_user, $id_tournament)
//    {
//        // Utilisez le Builder pour construire et exécuter la requête de suppression
//        $builder = $this->builder();
//        $builder->where('id_user', $id_user)
//            ->where('id_tournament', $id_tournament)
//            ->delete();
//
//        // Vérifiez si la suppression a réussi
//        return $this->db->affectedRows() > 0;
//    }

    public function delete_participant($id_tournament, $id_user) {
        // Supprime le tournoi avec l'identifiant donné
        $builder = $this->builder();
        $builder->where('id_user', $id_user)
                ->where('id_tournament', $id_tournament)
                ->delete('participant');
        // Vérifiez si la suppression a réussi
        return $this->db->affectedRows() > 0;

    }
}

