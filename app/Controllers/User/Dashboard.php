<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    protected $title      = 'Dashboard';
protected $require_auth = true;
    public function getIndex(): string
    {
        return $this->view('/user/dashboard/index.php', [], true);
    }

    public function getTest() {
        $this->error("Oh");
        $this->message("Oh");
        $this->success("Oh");
        $this->warning("Oh");
        $this->error("Oh");
        $this->redirect("/User/Dashboard");
    }
}