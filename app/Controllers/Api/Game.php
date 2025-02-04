<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Game extends ResourceController
{
    public function getallgames() {
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

    public function getgame($id = null) {
        if ($id == null) {
            return $this->respond(["message" => "Erreur, il faut un id"], 200);
        } else {
            $gm = Model('GameModel');
            $game = $gm->find($id);
            if (!$game) {
                return $this->respond(["message" => "Erreur, id introuvable"], 200);
            }
            return $this->respond( $game, 200);
        }
    }

    public function getjeu() {
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
        return $this->respond( $game, 200);
    }

    public function gettoken() {
        $data = $this->request->getGet();
        if(!isset($data['force_regenerate'])) {
            $data['force_regenerate'] = false;
        }
        if (isset($data['mail']) && isset($data['password'])){
            $um = Model('UserModel');
            $user = $um->verifyLogin($data['mail'], $data['password']);
            if (isset($user['id'])) {
                $token = generateToken($user['id'], $data['force_regenerate']);
                return $this->respond(['token' => $token], 200);
            } else {
                return $this->respond(["message" => "Erreur, identifiant ou password incorrect"], 500);
            }
        }
        return $this->respond(["message" => "Erreur, identifiant ou password inexistant"], 500);
    }

}
