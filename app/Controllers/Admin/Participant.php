<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Participant extends BaseController
{
    protected $require_auth = true;
    protected $requiredPermissions = ['administrateur'];
    protected $breadcrumb = [
        ['text' => 'Tableau de Bord', 'url' => '/admin/dashboard'],
        ['text' => 'Gestion des participants', 'url' => '/admin/participant']
    ];
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getindex($action = null, $id = null)
    {
        $pm = model("ParticipantModel");

        if ($action == null && $id == null) {
            $participants = $pm->getParticipantCategory(); // Récupérer les participants avec leurs relations
            return $this->view("/admin/participant/index", ['participants' => $participants], true);
        }

        if ($action == "new") {
            $this->addBreadcrumb('Création d\'un participant', '');
            $users = $this->db->table('user')->get()->getResultArray(); // Récupérer les utilisateurs
            $tournaments = $this->db->table('tournament')->get()->getResultArray(); // Récupérer les tournois
            return $this->view("/admin/participant/participant", [
                'users' => $users,
                'tournaments' => $tournaments
            ], true);
        }

        if ($action == "edit" && $id != null) {
            $participant = $pm->find($id);
            if ($participant) {
                $this->addBreadcrumb('Modification du participant numéro ' . $participant['id'], '');
                $users = $this->db->table('user')->get()->getResultArray(); // Récupérer les utilisateurs
                $tournaments = $this->db->table('tournament')->get()->getResultArray(); // Récupérer les tournois
                return $this->view("/admin/participant/participant", [
                    'participant' => $participant,
                    'users' => $users,
                    'tournaments' => $tournaments
                ], true);
            } else {
                $this->error("L'ID participant n'existe pas");
                return $this->redirect("/admin/participant");
            }
        }

        $this->error("Action non reconnue");
        return $this->redirect("/admin/participant");
    }

    public function postcreate()
    {
        $data = $this->request->getPost();
        $pm = model("ParticipantModel");

        if ($pm->insert($data)) {
            $this->success("Le participant a bien été ajouté.");
            return $this->redirect("/admin/participant");
        } else {
            $errors = $pm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            return $this->redirect("/admin/participant/new");
        }
    }

    public function postupdate()
    {
        $data = $this->request->getPost();
        $pm = model("ParticipantModel");

        if ($pm->update($data['id'], $data)) {
            $this->success("Le participant a bien été modifié.");
        } else {
            $errors = $pm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        return $this->redirect("/admin/participant");
    }

    public function delete($id)
    {
        $pm = model("ParticipantModel");

        if ($pm->delete($id)) {
            $this->success("Le participant a bien été supprimé.");
        } else {
            $this->error("Une erreur est survenue lors de la suppression du participant.");
        }

        return $this->redirect("/admin/participant");
    }
}
