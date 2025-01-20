<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\Admin\Participant;

class Tournament extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb = [['text' => 'Tableau de Bord', 'url' => '/admin/dashboard'], ['text' => 'Gestion des tournois', 'url' => '/admin/tournament']];
    protected $db;

    public function __construct()
    {
        // Initialisation de la base de données
        $this->db = \Config\Database::connect();
    }

    public function getindex($action = null, $id = null)
    {
        $tm = model("TournamentModel");
        $games = $this->db->table('game')->select('id, name')->get()->getResultArray();
        $GameNames = [];
        foreach ($games as $game) {
            $GameNames[$game['id']] = $game['name'];
        }
        if ($action == null && $id == null) {
            // Récupérer tous les tournois
            $tournaments = $tm->withDeleted()->findAll();

            // Associer le nom de la catégorie à chaque tournois
            foreach ($tournaments as &$tournament) {
                $tournament['game_name'] = isset($GameNames[$tournament['id_game']]) ? $GameNames[$tournament['id_game']] : 'Inconnue';
            }

            return $this->view("/admin/tournament/index", ['tournaments' => $tournaments], true);
        }


        if ($action == "new") {
            $this->addBreadcrumb('Création d\'un tournois', '');
            return $this->view("/admin/tournament/tournament", ['games' => $games], true);
        }
        if ($action == "edit" && $id != null) {
            $tournois = $tm->find($id);
            if ($tournois) {
                $this->addBreadcrumb('Modification de ' . $tournois['name'], '');
                return $this->view("/admin/tournament/tournament", ["tournois" => $tournois, "games" => $games], true);
            } else {
                $this->error("L'ID du tournois n'existe pas");
                return $this->redirect("/admin/tournament");
            }
        }
        $this->error("Action non reconnue");
        return $this->redirect("/admin/tournament");
    }

    public function postcreate()
    {
        $data = $this->request->getPost();
        $tm = Model("TournamentModel");

        $data['nb_player'] = $this->request->getPost('nb_player'); // 'number' correspond au name dans le formulaire
        $data['date_start'] = $this->request->getPost('date_start'); // 'date_deb' correspond au name dans le formulaire
        $data['date_end'] = $this->request->getPost('date_end'); // 'date_fin' correspond au name dans le formulaire

        // Validation des champs obligatoires
        if (empty($data['name']) || empty($data['id_game']) || empty($data['nb_player']) || empty($data['date_start']) || empty($data['date_end'])) {
            $this->error("Tous les champs obligatoires doivent être remplis.");
            return $this->redirect("/admin/tournament/new");
        }

        // Créer l'utilisateur et obtenir son ID
        $newTournamentId = $tm->createTournament($data);

        // Vérifier si la création a réussi
        if ($newTournamentId) {
            // Vérifier si des fichiers ont été soumis dans le formulaire
            $file = $this->request->getFile('tournament_image'); // 'profile_image' est le nom du champ dans le formulaire
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                // Préparer les données du média
                $mediaData = [
                    'entity_type' => 'tournament',
                    'entity_id' => $newTournamentId,   // Utiliser le nouvel ID de l'utilisateur
                ];

                // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
                $uploadResult = upload_file($file, 'avatartournament', $data['name'], $mediaData);

                // Vérifier le résultat de l'upload
                if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                    // Afficher un message d'erreur détaillé et rediriger
                    $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                    return $this->redirect("/admin/tournament/new");
                }
            }
            $this->success("Le tournois à bien été ajouté.");
            $this->redirect("/admin/tournament");
        } else {
            $errors = $tm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/tournament/new");
        }
    }

    public function postupdate()
    {
        // Récupération des données envoyées via POST
        $data = $this->request->getPost();

        // Récupération du modèle tournamentModel
        $tm = Model("TournamentModel");

        // Vérifier si un fichier a été soumis dans le formulaire
        $file = $this->request->getFile('tournament_image'); // 'profile_image' est le nom du champ dans le formulaire
        // Si un fichier a été soumis
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            // Récupération du modèle MediaModel
            $mm = Model('MediaModel');
            // Récupérer l'ancien média avant l'upload
            $old_media = $mm->getMediaByEntityIdAndType($data['id'], 'tournament');

            // Préparer les données du média pour le nouvel upload
            $mediaData = [
                'entity_type' => 'tournament',
                'entity_id' => $data['id'],   // Utiliser l'ID de l'utilisateur
            ];

            // Utiliser la fonction upload_file() pour gérer l'upload et enregistrer les données du média
            $uploadResult = upload_file($file, 'avatartournament', $data['name'], $mediaData, true, ['image/jpeg', 'image/png', 'image/jpg']);

            // Vérifier le résultat de l'upload
            if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                // Afficher un message d'erreur détaillé et rediriger
                $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                return $this->redirect("/admin/tournament");
            }

            // Si l'upload est un succès, suppression de l'ancien média
            if ($old_media) {
                $mm->deleteMedia($old_media[0]['id']);
            }
        }

        // Mise à jour des informations utilisateur dans la base de données
        if ($tm->updateTournament($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("Le tournois a bien été modifié.");
        } else {
            $errors = $tm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        // Redirection vers la page des utilisateurs après le traitement
        return $this->redirect("/admin/tournament");
    }

    public function getdeactivate($id)
    {
        $tm = Model('TournamentModel');
        if ($tm->deleteTournament($id)) {
            $this->success("tournois désactivé");
        } else {
            $this->error("tournois non désactivé");
        }
        $this->redirect('/admin/tournament');
    }

    public function getactivate($id)
    {
        $tm = Model('TournamentModel');
        if ($tm->activateTournament($id)) {
            $this->success("tournois activé");
        } else {
            $this->error("tournois non activé");
        }
        $this->redirect('/admin/tournament');
    }

    /**
     * Renvoie pour la requete Ajax les stocks fournisseurs rechercher par SKU ( LIKE )
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function postSearchTournament()
    {
        $TournamentModel = model('App\Models\TournamentModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw = $this->request->getPost('draw');
        $start = $this->request->getPost('start');
        $length = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDirection = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'] ?? 'id';


        // Obtenez les données triées et filtrées
        $data = $TournamentModel->getPaginatedTournaments($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $TournamentModel->getTotalTournaments();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $TournamentModel->getFilteredTournaments($searchValue);

        $result = [
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function getindexParticipant()
    {
        $pm = model("ParticipantModel");

        $participants = $pm->withDeleted()->findAll();
    }

}