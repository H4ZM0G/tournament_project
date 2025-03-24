<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Qualification extends BaseController
{
    public function index()
    {


        $qm = model("QualificationModel");

        // Récupération des données de l'URL
        $id_user = $this->request->getGet('id_user');
        $id_tournament = $this->request->getGet('id_tournament');

        // Vérification si l'utilisateur est déjà inscrit
        if ($qm->where(['id_user' => $id_user, 'id_tournament' => $id_tournament])->first()) {
            return redirect()->back()->with('error', 'Vous êtes déjà inscrit à ce tournoi.');
        }

        // Insertion de l'inscription dans la table qualification


        if ($qm->insert($data)) {
            return redirect()->back()->with('success', 'Inscription réussie à la phase de qualification.');
        } else {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'inscription.');
        }
    }

}
