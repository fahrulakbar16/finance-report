<?php

namespace App\Actions\Villa;

use App\Models\Villa;

class CreateVillaAction
{
    /**
     * Create a new Villa.
     *
     * @param array $data
     * @return Villa
     */
    public function execute(array $data): Villa
    {
        return Villa::create([
            'pemilik_id' => $data['pemilik_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'description' => $data['description'] ?? null,
            // image handling would go here if implemented
        ]);
    }
}
