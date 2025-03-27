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
                return $this->respond(['message' => "Liste des jeux", "games" => $gm->getAllGames()], 200);
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
}
