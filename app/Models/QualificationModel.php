<?php

namespace App\Models;

use CodeIgniter\Model;

class QualificationModel extends Model
{
    protected $table = 'qualification';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_tournament', 'status', 'libelle_status'];


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

    public function getQualifierWithDetails($id_tournament)
    {
        // Modification de la requête pour utiliser l'id du tournoi passé en paramètre
        $query = $this->db->table($this->table)
            ->select('qualification.*, user.*, tournament.*')
            ->join('user', 'qualification.id_user = user.id')
            ->join('tournament', 'qualification.id_tournament = tournament.id')
            ->where('qualification.id_tournament', $id_tournament)  // Utilisation de la variable $id_tournament
            ->get();

        return $query->getResultArray();
    }

    public function getQualifierWithUser()
    {
        $builder = $this->db->table('qualification');
        $builder->select('qualification.*, user.username as user_name');
        $builder->join('user', 'user.id = qualification.id_user', 'left'); // Jointure correcte entre id_user et id
        return $builder->get()->getResultArray(); // Récupère les résultats sous forme de tableau associatif
    }

    public function insertqualifier($id_tournament, $id_user)
    {
        $builder = $this->builder();
        // Prépare un tableau associatif avec les données à insérer
        $data = [
            'id_user' => $id_user,
            'id_tournament' => $id_tournament,
            'status' => 0, // Par défaut : "En attente"
            'libelle_status' => 'En attente'
        ];
        // Utilise la méthode insert pour insérer ces données
        return $builder->insert($data);
    }


    public function delete_qualifier($id_tournament, $id_user)
    {
        // Supprime le tournoi avec l'identifiant donné
        $builder = $this->builder();
        $builder->where('id_user', $id_user)
            ->where('id_tournament', $id_tournament)
            ->delete('qualification');
        // Vérifiez si la suppression a réussi
        return $this->db->affectedRows() > 0;

    }

    public function Unregisterqualifier($id_tournament, $id_user)
    {
        $this->db->table('qualification')->delete(['id_tournament' => $id_tournament, 'id_user' => $id_user]);
    }
}