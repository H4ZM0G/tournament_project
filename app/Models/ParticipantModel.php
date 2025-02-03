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
        // Modification de la requête pour utiliser l'id du tournoi passé en paramètre
        $query = $this->db->table($this->table)
            ->select('participant.*, user.*, tournament.*')
            ->join('user', 'participant.id_user = user.id')
            ->join('tournament', 'participant.id_tournament = tournament.id')
            ->where('participant.id_tournament', $id_tournament)  // Utilisation de la variable $id_tournament
            ->get();

        return $query->getResultArray();
    }
    public function getParticipantWithUser()
    {
        $builder = $this->db->table('participant');
        $builder->select('participant.*, user.username as user_name');
        $builder->join('user', 'user.id = participant.id_user', 'left'); // Jointure correcte entre id_user et id
        return $builder->get()->getResultArray(); // Récupère les résultats sous forme de tableau associatif
    }

    public function insertParticipant($id_tournament, $id_user) {
        $builder = $this->builder();
        // Prépare un tableau associatif avec les données à insérer
        $data = [
            'id_tournament' => $id_tournament,
            'id_user' => $id_user
        ];
        // Utilise la méthode insert pour insérer ces données
        return $builder->insert($data);
    }


    public function delete_participant($id_tournament, $id_user) {
        // Supprime le tournoi avec l'identifiant donné
        $builder = $this->builder();
        $builder->where('id_user', $id_user)
                ->where('id_tournament', $id_tournament)
                ->delete('participant');
        // Vérifiez si la suppression a réussi
        return $this->db->affectedRows() > 0;

    }

    public function UnregisterParticipant($id_tournament, $id_user) {
        $this->db->table('participant')->delete(['id_tournament' => $id_tournament, 'id_user' => $id_user]);
    }
}

