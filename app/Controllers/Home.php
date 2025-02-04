<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $require_auth = false;
    public function index(): string
    {
        return view('/login/login');
    }

    public function getforbidden() : string
    {
        return view('/templates/forbidden');
    }
}
