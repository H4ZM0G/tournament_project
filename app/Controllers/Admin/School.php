<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class School extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard'],['text'=> 'Gestion des écoles', 'url' => '/admin/school']];

    protected $db;

    public function __construct()
    {
        // Initialisation de la base de données
        $this->db = \Config\Database::connect();
    }

    public function getindex($action = null, $id = null)
    {
        $sm = model("SchoolModel");
        $categories = $this->db->table('school_category')->select('id, name')->get()->getResultArray();
        $categoryNames = [];
        foreach ($categories as $category) {
            $categoryNames[$category['id']] = $category['name'];
        }


        if ($action == null && $id == null) {
            // Récupérer tous les ecoles
            $schools = $sm->withDeleted()->findAll();

            // Associer le nom de la catégorie à chaque ecole
            foreach ($schools as &$school) {
                $school['category_name'] = isset($categoryNames[$school['id_category']]) ? $categoryNames[$school['id_category']] : 'Inconnue';
            }

            return $this->view("/admin/school/index", ['schools' => $schools], true);
        }

        $categories = $this->db->table('school_category')->select('id, name')->get()->getResultArray();
        if ($action == "new") {
            $this->addBreadcrumb('Création d\'un ecole', '');
            return $this->view("/admin/school/school", ['categories' => $categories], true);
        }
        if ($action == "edit" && $id != null) {
            $ecole = $sm->find($id);
            if ($ecole) {
                $this->addBreadcrumb('Modification de ' . $ecole['name'], '');
                return $this->view("/admin/school/school", ["ecole" => $ecole, "categories" => $categories], true);
            } else {
                $this->error("L'ID de l'ecole n'existe pas");
                return $this->redirect("/admin/school");
            }
        }
        $this->error("Action non reconnue");
        return $this->redirect("/admin/school");
    }

    public function postupdate() {
        $data = $this->request->getPost();
        $sm = model("SchoolModel");


        $ecole = $sm->find($data['id']);
        if (!$ecole) {
            $this->error("L'école 'n'existe pas.");
            return $this->redirect("/admin/school");
        }

        if ($sm->update($data['id'], $data)) {
            $this->success("L'école a bien été modifiée.");
        } else {
            $errors = $sm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

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
