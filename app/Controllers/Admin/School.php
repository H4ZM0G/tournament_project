<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Model;

class School extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb =  [['text' => 'Tableau de Bord','url' => '/admin/dashboard'],['text'=> 'Gestion des écoles', 'url' => '/admin/school']];

    public function getindex($id = null)
    {
        $sm = Model("SchoolModel");
        $um = Model("UserModel");
        if ($id == null) {
            $users = $um->getPermissions();
            return $this->view("/admin/user/index.php", ['users' => $users], true);
        } else {
            $permissions = Model("UserPermissionModel")->getAllPermissions();
            if ($id == "new") {
                $this->addBreadcrumb('Création d\' école', '');
                return $this->view("/admin/school/index", ["permissions" => $permissions], true);
            }
            $ecole = $sm->getUserById($id);
            if ($ecole) {
                $this->addBreadcrumb('Modification de ' . $ecole['name'], '');
                return $this->view("/admin/school/index", ["ecole" => $ecole, "permissions" => $permissions], true);
            } else {
                $this->error("L'ID de l'école n'existe pas");
                $this->redirect("/admin/school");
            }
        }
    }
}
