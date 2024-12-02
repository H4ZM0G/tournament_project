<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Home extends BaseController
{
    protected $title      = 'Tableau de Bord';
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];

    public function getindex(): string
    {
        $um = Model("App\Models\UserModel");
        $infosUser = $um->countUserByPermission();
        return $this->view('/admin/dashboard/index.php', ['infosUser' => $infosUser], true);
    }

    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }
}