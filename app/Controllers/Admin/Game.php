<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
class Game extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard'],['text'=> 'Gestion des utilisateurs', 'url' => '/admin/game']];
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
        $gm = Model("GameModel");

        // Créer l'utilisateur et obtenir son ID
        $newGameId = $gm->createGame($data);

        // Vérifier si la création a réussi
        if ($newGameId) {
            // Vérifier si des fichiers ont été soumis dans le formulaire
            $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire
            if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                // Préparer les données du média
                $mediaData = [
                    'entity_type' => 'game',
                    'entity_id'   => $newGameId,   // Utiliser le nouvel ID de l'utilisateur
                ];

                // Utiliser la fonction upload_file() pour gérer l'upload et les données du média
                $uploadResult = upload_file($file, 'avatar', $data['name'], $mediaData);

                // Vérifier le résultat de l'upload
                if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                    // Afficher un message d'erreur détaillé et rediriger
                    $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                    return $this->redirect("/admin/game/new");
                }
            }
            $this->success("Le jeu à bien été ajouté.");
            $this->redirect("/admin/game");
        } else {
            $errors = $gm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/game/new");
        }
    }

    public function postupdate() {
        // Récupération des données envoyées via POST
        $data = $this->request->getPost();

        // Récupération du modèle GameModel
        $gm = Model("GameModel");

        // Vérifier si un fichier a été soumis dans le formulaire
        $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire
        // Si un fichier a été soumis
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            // Récupération du modèle MediaModel
            $mm = Model('MediaModel');
            // Récupérer l'ancien média avant l'upload
            $old_media = $mm->getMediaByEntityIdAndType($data['id'], 'game');

            // Préparer les données du média pour le nouvel upload
            $mediaData = [
                'entity_type' => 'game',
                'entity_id'   => $data['id'],   // Utiliser l'ID de l'utilisateur
            ];

            // Utiliser la fonction upload_file() pour gérer l'upload et enregistrer les données du média
            $uploadResult = upload_file($file, 'avatar', $data['name'], $mediaData, true, ['image/jpeg', 'image/png','image/jpg']);

            // Vérifier le résultat de l'upload
            if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                // Afficher un message d'erreur détaillé et rediriger
                $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                return $this->redirect("/admin/game");
            }

            // Si l'upload est un succès, suppression de l'ancien média
            if ($old_media) {
                $mm->deleteMedia($old_media[0]['id']);
            }
        }

        // Mise à jour des informations utilisateur dans la base de données
        if ($gm->updateGame($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("Le jeu a bien été modifié.");
        } else {
            $errors = $gm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        // Redirection vers la page des utilisateurs après le traitement
        return $this->redirect("/admin/game");
    }

    public function getdeactivate($id){
        $gm = Model('GameModel');
        if ($gm->deleteGame($id)) {
            $this->success("Jeu désactivé");
        } else {
            $this->error("Jeu non désactivé");
        }
        $this->redirect('/admin/game');
    }

    public function getactivate($id){
        $gm = Model('GameModel');
        if ($gm->activateGame($id)) {
            $this->success("Jeu activé");
        } else {
            $this->error("Jeu non activé");
        }
        $this->redirect('/admin/game');
    }

    /**
     * Renvoie pour la requete Ajax les stocks fournisseurs rechercher par SKU ( LIKE )
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
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
}