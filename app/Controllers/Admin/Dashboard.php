<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $title      = 'Dashboard';
protected $require_auth = true;
    public function getIndex(): string
    {
        return $this->view('/admin/dashboard/index.php', [], true);
    }

    public function getTest() {
        $this->error("Oh");
        $this->message("Oh");
        $this->success("Oh");
        $this->warning("Oh");
        $this->error("Oh");
        $this->redirect("/Admin/Dashboard");
    }
}