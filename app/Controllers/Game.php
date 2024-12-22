<?php

namespace App\Controllers;

class Game extends BaseController
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
        $gm = model("GameModel");
        $categories = $this->db->table('game_category')->select('id, name')->get()->getResultArray();
        $categoryNames = [];
        foreach ($categories as $category) {
            $categoryNames[$category['id']] = $category['name'];
        }


        if ($action == null && $id == null) {
            // Récupérer tous les jeux
            $games = $gm->withDeleted()->getGamesWithMedia();

            // Associer le nom de la catégorie à chaque jeu
            foreach ($games as &$game) {
                $game['category_name'] = isset($categoryNames[$game['id_category']]) ? $categoryNames[$game['id_category']] : 'Inconnue';
            }

            return $this->view("/front/game/index", ['games' => $games], true);
        }

        $categories = $this->db->table('game_category')->select('id, name')->get()->getResultArray();
        if ($action == "new") {
            $this->addBreadcrumb('Création d\'un jeu', '');
            return $this->view("/front/game/game", ['categories' => $categories], true);
        }
        if ($action == "edit" && $id != null) {
            $jeu = $gm->find($id);
            if ($jeu) {
                $this->addBreadcrumb('Modification de ' . $jeu['name'], '');
                return $this->view("/front/game/game", ["jeu" => $jeu, "categories" => $categories], true);
            } else {
                $this->error("L'ID du jeu n'existe pas");
                return $this->redirect("/front/game");
            }
        }
        $this->error("Action non reconnue");
        return $this->redirect("/front/game");
    }

    public function postSearchGame()
    {
        $GameModel = model('App\Models\GameModel');

        // Paramètres de pagination et de recherche envoyés par DataTables
        $draw        = $this->request->getPost('draw');
        $start       = $this->request->getPost('start');
        $length      = $this->request->getPost('length');
        $searchValue = $this->request->getPost('search')['value'];

        // Obtenez les informations sur le tri envoyées par DataTables
        $orderColumnIndex = $this->request->getPost('order')[0]['column'] ?? 0;
        $orderDirection = $this->request->getPost('order')[0]['dir'] ?? 'asc';
        $orderColumnName = $this->request->getPost('columns')[$orderColumnIndex]['data'] ?? 'id';


        // Obtenez les données triées et filtrées
        $data = $GameModel->getPaginatedGames($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $GameModel->getTotalGames();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $GameModel->getFilteredGames($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

    public function index()
    {
        $gameModel = model('GameModel');
        $games = $gameModel->getGamesWithMedia();

        return view('front/game/index', ['games' => $games]);
    }
}