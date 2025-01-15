<?php

namespace App\Controllers;

class User extends BaseController
{
//    protected $require_auth = true;
    protected $db;
    public function __construct()
    {
        // Initialisation de la base de données
        $this->db = \Config\Database::connect();
    }

    public function getindex($id = null) {

        $um = Model("UserModel");
        if ($id == null) {
            $users = $um->getPermissions();
            return $this->view("/front/user/index.php",['users' => $users]);
        } else {
            $permissions = Model("UserPermissionModel")->getAllPermissions();
            if ($id == "new") {
                $this->addBreadcrumb('Création d\' un utilisateur','');
                return $this->view("/front/user/user",["permissions" => $permissions]);
            }
            $utilisateur = $um->getUserById($id);
            if ($utilisateur) {
                $this->addBreadcrumb('Modification du Profil', '');
                return $this->view("/front/user/user", ["utilisateur" => $utilisateur, "permissions" => $permissions ]);
            } else {
                $this->error("L'ID de l'utilisateur n'existe pas");
                $this->redirect("/front/user");
            }
        }
    }

    public function postupdate() {
        // Récupération des données envoyées via POST
        $data = $this->request->getPost();

        // Récupération du modèle UserModel
        $um = Model("UserModel");

        // Vérifier si un fichier a été soumis dans le formulaire
        $file = $this->request->getFile('profile_image'); // 'profile_image' est le nom du champ dans le formulaire
        // Si un fichier a été soumis
        if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
            // Récupération du modèle MediaModel
            $mm = Model('MediaModel');
            // Récupérer l'ancien média avant l'upload
            $old_media = $mm->getMediaByEntityIdAndType($data['id'], 'user');

            // Préparer les données du média pour le nouvel upload
            $mediaData = [
                'entity_type' => 'user',
                'entity_id'   => $data['id'],   // Utiliser l'ID de l'utilisateur
            ];

            // Utiliser la fonction upload_file() pour gérer l'upload et enregistrer les données du média
            $uploadResult = upload_file($file, 'avatar', $data['username'], $mediaData, true, ['image/jpeg', 'image/png','image/jpg']);

            // Vérifier le résultat de l'upload
            if (is_array($uploadResult) && $uploadResult['status'] === 'error') {
                // Afficher un message d'erreur détaillé et rediriger
                $this->error("Une erreur est survenue lors de l'upload de l'image : " . $uploadResult['message']);
                return $this->redirect("/front/user");
            }

            // Si l'upload est un succès, suppression de l'ancien média
            if ($old_media) {
                $mm->deleteMedia($old_media[0]['id']);
            }
        }

        // Mise à jour des informations utilisateur dans la base de données
        if ($um->updateUser($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("L'utilisateur a bien été modifié.");
        } else {
            $errors = $um->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        // Redirection vers la page des utilisateurs après le traitement
        return $this->redirect("/Dashboard");
    }

    public function getdeactivate($id){
        $um = Model('UserModel');
        if ($um->deleteUser($id)) {
            $this->success("Utilisateur désactivé");
        } else {
            $this->error("Utilisateur non désactivé");
        }
        $this->redirect('/front/user');
    }

    public function getactivate($id){
        $um = Model('UserModel');
        if ($um->activateUser($id)) {
            $this->success("Utilisateur activé");
        } else {
            $this->error("Utilisateur non activé");
        }
        $this->redirect('/front/user');
    }

    /**
     * Renvoie pour la requete Ajax les stocks fournisseurs rechercher par SKU ( LIKE )
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function postSearchUser()
    {
        $UserModel = model('App\Models\UserModel');

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
        $data = $UserModel->getPaginatedUser($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $UserModel->getTotalUser();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $UserModel->getFilteredUser($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}