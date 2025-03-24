<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Game extends ResourceController
{
    public function getallgames()
    {
        $token = $this->request->getHeaderLine('Authorization');

        if ($token && preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $userId = validateToken($matches[1]);
            if ($userId) {
                $gm = Model('GameModel');
                return $this->respond(['message' => "Liste des jeux", "games" => $gm->getAllGamesTitleOnly()], 200);
            }
        }
        return $this->failUnauthorized('Invalid or expired token or attempts limit pass');
    }

    public function getgame($id = null)
    {
        if ($id == null) {
            return $this->respond(["message" => "Erreur, il faut un id"], 200);
        } else {
            $gm = Model('GameModel');
            $game = $gm->find($id);
            if (!$game) {
                return $this->respond(["message" => "Erreur, id introuvable"], 200);
            }
            return $this->respond($game, 200);
        }
    }

    public function getjeu()
    {
        $data = $this->request->getGet();
        if (!$data) {
            return $this->respond(["message" => "Erreur, pas de données reçu"], 500);
        }
        if (!isset($data['id'])) {
            return $this->respond(["message" => "Erreur, il faut un id"], 500);
        }
        $gm = Model('GameModel');
        $game = $gm->find($data['id']);
        if (!$game) {
            return $this->respond(["message" => "Erreur, id introuvable"], 500);
        }
        return $this->respond($game, 200);
    }


    public function postlogin()
    {
        $userModel = new UserModel();
        $blacklistModel = new BlacklistModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Récupération de l'utilisateur
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON(['message' => 'Erreur, identifiant ou mot de passe incorrect'])->setStatusCode(401);
        }

        // Vérifier si l'utilisateur est en blacklist
        $isBlacklisted = $blacklistModel->where('user_id', $user['id'])->first();
        if ($isBlacklisted) {
            return $this->response->setJSON(['message' => 'Compte bloqué, veuillez contacter l\'administration'])->setStatusCode(403);
        }

        // Vérification du mot de passe
        if (!password_verify($password, $user['password'])) {
            // Décrémentation du compteur d'essais
            $userModel->decrementCounterUser($user['id']); // Décrémente le compteur

            // Recharger l'utilisateur après mise à jour du compteur
            $user = $userModel->find($user['id']); // Recharger les données après mise à jour

            // Vérification si le compteur atteint 0
            if ($user['counter_user'] <= 0) {
                // Ajouter l'utilisateur à la table blacklist avec created_at
                $blacklistModel->addToBlacklistuser($user['id']);

                return $this->response->setJSON(['message' => 'Compte bloqué et ajouté en blacklist'])->setStatusCode(403);
            }

            return $this->response->setJSON(['message' => 'Erreur, identifiant ou mot de passe incorrect'])->setStatusCode(401);
        }

        // Réinitialisation du compteur après une connexion réussie
        $userModel->resetCounter($email);

        // Vérifier si un token existe déjà pour cet utilisateur
        $atm = Model('ApiTokenModel');
        $apiToken = $atm->where('user_id', $user['id'])->first();

        if ($apiToken) {
            // Token déjà existant, le renvoyer
            return $this->response->setJSON(['token' => $apiToken['token']]);
        } else {
            // Si aucun token n'existe, utiliser la fonction gettoken pour le générer
            return $this->gettoken($user['id']);
        }
    }

    public function gettoken($userId = null)
    {

     public function gettoken($userId = null) {

        $data = $this->request->getGet();

        if (!isset($data['force_regenerate'])) {
            $data['force_regenerate'] = false;
        }


        if ($userId !== null) {
            $um = Model('UserModel');
            $user = $um->find($userId);
        }
        // Sinon, utiliser mail + password pour vérifier l'utilisateur
        else if (isset($data['mail']) && isset($data['password'])) {
            $um = Model('UserModel');
            $user = $um->verifyLogin($data['mail'], $data['password']);
        } else {
            return $this->respond(["message" => "Erreur, identifiant ou mot de passe manquant"], 400);
        }

        // Vérifier que l'utilisateur existe
        if (!isset($user['id'])) {
            return $this->respond(["message" => "Erreur, identifiant ou mot de passe incorrect"], 401);
        }

        return $this->respond(["message" => "Erreur, identifiant ou password inexistant"], 500);


        // Vérifier si l'utilisateur est blacklisté
        $bm = Model('BlacklistModel');
        $isBlacklisted = $bm->where('user_id', $user['id'])->first();
        if ($isBlacklisted) {
            return $this->respond(["message" => "Utilisateur bloqué, impossible de générer un jeton"], 403);
        }

        // Supprimer l'ancien token s'il existe
        $atm = Model('ApiTokenModel');
        $atm->where('user_id', $user['id'])->delete();

        // Générer un nouveau token
        $token = generateToken($user['id'], $data['force_regenerate']);

        return $this->respond(['token' => $token], 200);
    }

    public function postlogin()
    {
        $userModel = new UserModel();
        $blacklistModel = new BlacklistModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Récupération de l'utilisateur
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return $this->response->setJSON(['message' => 'Erreur, identifiant ou mot de passe incorrect'])->setStatusCode(401);
        }

        // Vérifier si l'utilisateur est en blacklist
        $isBlacklisted = $blacklistModel->where('user_id', $user['id'])->first();
        if ($isBlacklisted) {
            return $this->response->setJSON(['message' => 'Compte bloqué, veuillez contacter l\'administration'])->setStatusCode(403);
        }

        // Vérification du mot de passe
        if (!password_verify($password, $user['password'])) {
            // Décrémentation du compteur d'essais
            $userModel->decrementCounterUser($user['id']); // Décrémente le compteur

            // Recharger l'utilisateur après mise à jour du compteur
            $user = $userModel->find($user['id']); // Recharger les données après mise à jour

            // Vérification si le compteur atteint 0
            if ($user['counter_user'] <= 0) {
                // Ajouter l'utilisateur à la table blacklist avec created_at
                $blacklistModel->addToBlacklistuser($user['id']);

                return $this->response->setJSON(['message' => 'Compte bloqué et ajouté en blacklist'])->setStatusCode(403);
            }

            return $this->response->setJSON(['message' => 'Erreur, identifiant ou mot de passe incorrect'])->setStatusCode(401);
        }

        // Réinitialisation du compteur après une connexion réussie
        $userModel->resetCounter($email);

        // Vérifier si un token existe déjà pour cet utilisateur
        $atm = Model('ApiTokenModel');
        $apiToken = $atm->where('user_id', $user['id'])->first();

        if ($apiToken) {
            // Token déjà existant, le renvoyer
            return $this->response->setJSON(['token' => $apiToken['token']]);
        } else {
            // Si aucun token n'existe, utiliser la fonction gettoken pour le générer
            return $this->gettoken($user['id']);
        }
    }
}
