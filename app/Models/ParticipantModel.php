<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantModel extends Model
{
    protected $table = 'participant';

    // Champs permis pour les opérations d'insertion et de mise à jour
    protected $allowedFields = ['id_tournament', 'id_user'];

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
}
