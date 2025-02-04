<?php

use App\Models\ApiTokenModel;
use CodeIgniter\I18n\Time;

function generateToken($userId, $force_regen = false, $never_expired = false)
{
    $token = bin2hex(random_bytes(32)); // Crée un token sécurisé

    $expiresAt = Time::now()->addHours(24); // Expiration dans 24 heures
    if ($never_expired) {
        $expiresAt = null;
    }
    // Sauvegarder le token en BDD
    $apiTokenModel = new ApiTokenModel();
    $tokenData = $apiTokenModel->where('user_id', $userId)->first();
    if ($tokenData && ( $tokenData['expires_at'] < Time::now() || $force_regen == true ) ) {
        $apiTokenModel->update($tokenData['id'], [
            'user_id' => $userId,
            'token' => $token,
            //counter
            'created_at' => Time::now(),
            'expires_at' => $expiresAt,
        ]);
    } else {
        if ($tokenData) {
            return $tokenData['token'];
        }
        $apiTokenModel->insert([
            'user_id' => $userId,
            'token' => $token,
            'counter' => 10,
            'created_at' => Time::now(),
            'expires_at' => $expiresAt,
        ]);
    }
    return $token;
}

function validateToken($token)
{
    $apiTokenModel = new ApiTokenModel();
    $tokenData = $apiTokenModel->where('token', $token)->first();



    if ($tokenData && $tokenData['expires_at'] > Time::now() && $tokenData['counter'] > 0) {
        $apiTokenModel->decount($tokenData['user_id']);
        return $tokenData['user_id']; // Retourne l’ID utilisateur si valide
    }
    return null; // Token invalide ou expiré
}


