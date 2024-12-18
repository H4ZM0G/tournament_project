<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $title      = 'Tableau de Bord';
    protected $require_auth = true;
    protected $requiredPermissions = ['utilisateur'];

    public function getindex(): string
    {
        $um = Model("App\Models\UserModel");
        $infosUser = $um->countUserByPermission();
        return $this->view('/user/dashboard/index.php', ['infosUser' => $infosUser], true);
    }

    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }
}