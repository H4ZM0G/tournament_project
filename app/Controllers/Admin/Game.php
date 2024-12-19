<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Game extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord', 'url' => '/admin/dashboard'], ['text'=> 'Gestion des jeux', 'url' => '/admin/game']];
    protected $db; // Ajout de la propriété $db

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
            $games = $gm->withDeleted()->findAll();

            // Associer le nom de la catégorie à chaque jeu
            foreach ($games as &$game) {
                $game['category_name'] = isset($categoryNames[$game['id_category']]) ? $categoryNames[$game['id_category']] : 'Inconnue';
            }

            return $this->view("/admin/game/index", ['games' => $games], true);
        }

        $categories = $this->db->table('game_category')->select('id, name')->get()->getResultArray();
        if ($action == "new") {
            $this->addBreadcrumb('Création d\'un jeu', '');
            return $this->view("/admin/game/game", ['categories' => $categories], true);
        }
        if ($action == "edit" && $id != null) {
            $jeu = $gm->find($id);
            if ($jeu) {
                $this->addBreadcrumb('Modification de ' . $jeu['name'], '');
                return $this->view("/admin/game/game", ["jeu" => $jeu, "categories" => $categories], true);
            } else {
                $this->error("L'ID du jeu n'existe pas");
                return $this->redirect("/admin/game");
            }
        }
        $this->error("Action non reconnue");
        return $this->redirect("/admin/game");
    }

    public function postcreate() {
        $data = $this->request->getPost();
        $gm = model("GameModel");

        $newGameId = $gm->insert($data);

        if ($newGameId) {
            $this->success("Le jeu a bien été ajoutée.");
            return $this->redirect("/admin/game");
        } else {
            $errors = $gm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            return $this->redirect("/admin/game/new");
        }
    }

    public function postupdate() {
        $data = $this->request->getPost();
        $gm = model("GameModel");

        $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire

        $jeu = $gm->find($data['id']);
        if (!$jeu) {
            $this->error("Le jeu n'existe pas.");
            return $this->redirect("/admin/game");
        }

        if ($gm->update($data['id'], $data)) {
            $this->success("Le jeu a bien été modifiée.");
        } else {
            $errors = $gm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        return $this->redirect("/admin/game");
    }

    public function getdeactivate($id)
    {
        $gm = model('GameModel');

        try {
            if ($gm->update($id, ['deleted_at' => date('Y-m-d H:i:s')])) {
                $this->success("Jeu désactivé");
            } else {
                $this->error("Jeu non désactivé");
            }
        } catch (\Exception $e) {
            $this->error("Erreur : " . $e->getMessage());
        }

        return $this->redirect('/admin/game');
    }

    public function getactivate($id)
    {
        $gm = model('GameModel');

        try {
            if ($gm->update($id, ['deleted_at' => null])) {
                $this->success("Jeu activé");
            } else {
                $this->error("Jeu non activé");
            }
        } catch (\Exception $e) {
            $this->error("Erreur : " . $e->getMessage());
        }

        return $this->redirect('/admin/game');
    }


    public function new()
    {
        $categories = $this->db->table('game_category')->select('id, name')->get()->getResultArray();

        return view('admin/game_form', [
            'categories' => $categories,
        ]);
    }
    public function postSearchGame()
    {
        $GameModel = model('App\Models\GmeModel');

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
        $data = $GameModel->getPaginatedGame($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $GameModel->getTotalGame();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $GameModel->getFilteredGame($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}
