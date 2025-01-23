<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GameCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Action',
                'slug' => 'action'
            ],
            [
                'name' => 'Adventure',
                'slug' => 'adventure'
            ],
            [
                'name' => 'Battle Royale',
                'slug' => 'battle-royale'
            ],
            [
                'name' => 'Card Game',
                'slug' => 'card-game'
            ],
            [
                'name' => 'FPS',
                'slug' => 'fps'
            ],
            [
                'name' => 'MMORPG'
                , 'slug' => 'mmorpg'
            ],
            [
                'name' => 'MOBA',
                'slug' => 'moba'
            ],
            [
                'name' => 'Party Game',
                'slug' => 'party-game'
            ],
            [
                'name' => 'Platformer',
                'slug' => 'platformer'
            ],
            [
                'name' => 'Puzzle',
                'slug' => 'puzzle'
            ],
            [
                'name' => 'Racing',
                'slug' => 'racing'
            ],
            [
                'name' => 'Sandbox',
                'slug' => 'sandbox'
            ],
            [
                'name' => 'Simulation',
                'slug' => 'simulation'
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports'
            ],
            [
                'name' => 'Strategy',
                'slug' => 'strategy'
            ],
            [
                'name' => 'Survival',
                'slug' => 'survival'
            ],
            [
                'name' => 'Tactical Shooter',
                'slug' => 'tactical-shooter'
            ],
            [
                'name' => 'Turn-Based Strategy',
                'slug' => 'turn-based-strategy'
            ],
            [
                'name' => 'Horror',
                'slug' => 'horror'
            ],
            [
                'name' => 'RPG',
                'slug' => 'rpg'
            ],
        ];
        $this->db->table('game_category')->insertBatch($data);
    }
}
