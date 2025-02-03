<?php

namespace App\Controllers;

class Tournament extends BaseController
{
//    protected $require_auth = true;
    protected $db;

    public function __construct()
    {
        // Initialisation de la base de données
        $this->db = \Config\Database::connect();
    }

    public function getindex($action = null, $id = null)
    {
        $tm = model("TournamentModel");
        $pm = model("ParticipantModel");
        $categories = $this->db->table('game')->select('id, name')->get()->getResultArray();
        $categoryNames = [];
        foreach ($categories as $category) {
            $categoryNames[$category['id']] = $category['name'];
        }


        if ($action == null && $id == null) {
            // Récupérer tous les jeux
            $tournaments = $tm->withDeleted()->getTournamentsWithMediaFront();
            $participants = $pm->getParticipantWithUser();
            // Associer le nom de la catégorie à chaque jeu
            foreach ($tournaments as &$tournament) {
                $tournament['game_name'] = isset($categoryNames[$tournament['id_game']]) ? $categoryNames[$tournament['id_game']] : 'Inconnue';
            }

            return $this->view("/front/tournament/index", ['tournaments' => $tournaments, 'participants' => $participants]);
        }

        $categories = $this->db->table('game_category')->select('id, name')->get()->getResultArray();
        if ($action == "new") {
            $this->addBreadcrumb('Création d\'un jeu', '');
            return $this->view("/front/tournament/tournament", ['categories' => $categories]);
        }
        if ($action == "edit" && $id != null) {
            $tournois = $tm->find($id);
            if ($tournois) {
                $this->addBreadcrumb('Modification de ' . $tournois['name'], '');
                return $this->view("/front/tournament/tournament", ["jeu" => $tournois, "categories" => $categories],);
            } else {
                $this->error("L'ID du jeu n'existe pas");
                return $this->redirect("/tournament");
            }
        }
        $this->error("Action non reconnue");
        return $this->redirect("/tournament");
    }

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

    public function index()
    {
        $TournamentModel = model('TournamentModel');
        $tournaments = $TournamentModel->getTournamentsWithMediaFront();

        return view('front/tournament/index', ['tournaments' => $tournaments]);
    }

    public function getregister()
    {
        $pm = Model("ParticipantModel");

        $id_tournament = $this->request->getGet('id_tournament');
        $id_user = $this->request->getGet('id_user');

        $newParticipantId = $pm->insertParticipant($id_tournament, $id_user);
        if ($newParticipantId) {
            $this->success("Le participant à bien été inscrit au tournoi");
            $this->redirect('/tournament');
        } else {
            $errors = $pm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect('/tournament');
        }
    }

    public function getunregister()
    {
        $pm = Model("ParticipantModel");

        $id_tournament = $this->request->getGet('id_tournament');
        $id_user = $this->request->getGet('id_user');

        $unregister = $pm->UnregisterParticipant($id_tournament, $id_user);

        if ($unregister) {
            $this->success("Le participant à bien été inscrit au tournoi");
            $this->redirect('/tournament');
        } else {
            $errors = $pm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect('/tournament');
        }
    }

}