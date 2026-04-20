<?php

namespace App\Actions\Villa;

use App\Models\Villa;

class UpdateVillaAction
{
    /**
     * Update an existing Villa.
     *
     * @param Villa $villa
     * @param array $data
     * @return Villa
     */
    public function execute(Villa $villa, array $data): Villa
    {
        $villa->update([
            'pemilik_id' => $data['pemilik_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'description' => $data['description'] ?? null,
        ]);

        return $villa;
    }
}
