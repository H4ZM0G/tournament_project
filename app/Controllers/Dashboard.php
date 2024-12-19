<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    protected $title      = 'Dashboard';
protected $require_auth = true;
    public function getIndex(): string
    {
        return $this->view('/front/dashboard/index.php', [], true);
    }

    public function getTest() {
        $this->error("Oh");
        $this->message("Oh");
        $this->success("Oh");
        $this->warning("Oh");
        $this->error("Oh");
        $this->redirect("/Dashboard");
    }
}