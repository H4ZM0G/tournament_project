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

    public function getindex($action = null, $idTournament = null)
    {
        $pm = model("ParticipantModel");

        if ($action == null && $idTournament == null) {
            // Afficher la liste des participants
            $participants = $pm->getParticipantCategory(); // À ajuster selon ta logique
            return $this->view("/admin/participant/index", ['participants' => $participants], true);
        }

        if ($action == "new") {
            // Formulaire de création de participant
            $this->addBreadcrumb('Création d\'un participant', '');
            $users = $this->db->table('user')->get()->getResultArray();
            $tournaments = $this->db->table('tournament')->get()->getResultArray();
            return $this->view("/admin/participant/participant", [
                'users' => $users,
                'tournaments' => $tournaments
            ], true);
        }

        if ($action == "edit" && $idTournament != null) {
            // Afficher un formulaire pour modifier un participant
            $participant = $pm->find($idTournament);
            if ($participant) {
                $this->addBreadcrumb('Modification du participant', '');
                $users = $this->db->table('user')->get()->getResultArray();
                $tournaments = $this->db->table('tournament')->get()->getResultArray();
                return $this->view("/admin/participant/participant", [
                    'participant' => $participant,
                    'users' => $users,
                    'tournaments' => $tournaments
                ], true);
            } else {
                $this->error("Participant introuvable");
                return $this->redirect("/admin/participant");
            }
        }

        // Retourner une erreur si l'action n'est pas reconnue
        $this->error("Action non reconnue");
        return $this->redirect("/admin/participant");
    }

    public function postcreate()
    {
        $data = $this->request->getPost();
        $pm = model("ParticipantModel");

        // Valider les données
        if (!isset($data['id_tournament']) || !isset($data['id_user'])) {
            $this->error("Les informations sur le tournoi et l'utilisateur sont requises.");
            return $this->redirect("/admin/participant/new");
        }

        // Insertion du participant
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

        // Vérifier que l'ID existe dans les données
        if (!isset($data['id']) || !isset($data['id_tournament']) || !isset($data['id_user'])) {
            $this->error("Les informations nécessaires à la mise à jour sont manquantes.");
            return $this->redirect("/admin/participant");
        }

        // Mettre à jour le participant
        if ($pm->update($data['id'], $data)) {
            $this->success("Le participant a bien été modifié.");
            return $this->redirect("/admin/participant");
        } else {
            $errors = $pm->errors();
            foreach ($errors as $error) {
                $this->error($error);
            }
            return $this->redirect("/admin/participant/edit/{$data['id']}");
        }
    }

    public function delete($id)
    {
        $pm = model("ParticipantModel");

        // Suppression du participant
        if ($pm->delete($id)) {
            $this->success("Le participant a bien été supprimé.");
        } else {
            $this->error("Une erreur est survenue lors de la suppression du participant.");
        }

        return $this->redirect("/admin/participant");
    }

    public function getParticipantsByTournament($idTournament)
    {
        $pm = model("ParticipantModel");

        // Récupérer les participants en fonction du tournoi
        $participants = $pm->where('id_tournament', $idTournament)->findAll();

        // Vérifier s'il y a des participants
        if (empty($participants)) {
            $this->error("Aucun participant trouvé pour ce tournoi.");
            return $this->redirect("/admin/participant");
        }

        // Retourner la vue avec les participants associés au tournoi
        return $this->view("/admin/participant/index", ['participants' => $participants], true);
    }

    public function postSearchTournament()
    {
        $ParticipantModel = model('ParticipantModel');

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
        $data = $ParticipantModel->getPaginatedTournaments($start, $length, $searchValue, $orderColumnName, $orderDirection);

        // Obtenez le nombre total de lignes sans filtre
        $totalRecords = $ParticipantModel->getTotalTournaments();

        // Obtenez le nombre total de lignes filtrées pour la recherche
        $filteredRecords = $ParticipantModel->getFilteredTournaments($searchValue);

        $result = [
            'draw'            => $draw,
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data'            => $data,
        ];
        return $this->response->setJSON($result);
    }

}
