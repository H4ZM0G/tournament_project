<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class School extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard'],['text'=> 'Gestion des écoles', 'url' => '/admin/school']];

    public function getindex($id = null) {

        $sm = Model("SchoolModel");
        if ($id == null) {

            return $this->view("/admin/school/index.php",[], true);
        } else {
            $permissions = Model("UserPermissionModel")->getAllPermissions();
            if ($id == "new") {
                $this->addBreadcrumb('Création d\' une école','');
                return $this->view("/admin/school/school",["permissions" => $permissions], true);
            }
            $ecole = $sm->getUserById($id);
            if ($ecole) {
                $this->addBreadcrumb('Modification de ' . $ecole['name'], '');
                return $this->view("/admin/school/school", ["utilisateur" => $ecole, "permissions" => $permissions ], true);
            } else {
                $this->error("L'ID de l'école n'existe pas");
                $this->redirect("/admin/school");
            }
        }
    }

    public function postupdate() {
        // Récupération des données envoyées via POST
        $data = $this->request->getPost();

        // Récupération du modèle UserModel
        $sm = Model("SchoolModel");

        // Mise à jour des informations utilisateur dans la base de données
        if ($sm->updateSchool($data['id'], $data)) {
            // Si la mise à jour réussit
            $this->success("L'école a bien été modifié.");
        } else {
            $errors = $sm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        // Redirection vers la page des utilisateurs après le traitement
        return $this->redirect("/admin/school");
    }



    public function postcreate() {
        $data = $this->request->getPost();
        $sm = Model("SchoolModel");

        // Créer l'utilisateur et obtenir son ID
        $newSchoolId = $sm->createSchool($data);

        // Vérifier si la création a réussi
        if ($newSchoolId) {
            $this->success("L'école à bien été ajouté.");
            $this->redirect("/admin/school");
        } else {
            $errors = $sm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            $this->redirect("/admin/school/new");
        }
    }


    /**
     * Renvoie pour la requete Ajax les stocks fournisseurs rechercher par SKU ( LIKE )
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function postSearchSchool()
    {
        $SchoolModel = model('SchoolModel');

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
        $data = $SchoolModel->getPaginatedSchool($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $SchoolModel->getTotalSchool();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $SchoolModel->getFilteredSchool($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }
}
