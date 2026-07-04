<?php

namespace App\Actions\Villa;

use App\Models\Villa;
use Illuminate\Support\Facades\Storage;

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
        $imagePath = null;
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $data['image']->store('villas', 'public');
        }

        $villa = Villa::create([
            'pemilik_id' => $data['pemilik_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'image' => $imagePath,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'address' => $data['address'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'persenan_pengelola' => $data['persenan_pengelola'],
            'persenan_pemilik' => $data['persenan_pemilik'],
        ]);

        if (isset($data['rooms']) && is_array($data['rooms'])) {
            foreach ($data['rooms'] as $room) {
                if (!empty($room['name']) && !empty($room['amount'])) {
                    $villa->rooms()->create([
                        'name' => $room['name'],
                        'amount' => $room['amount'],
                    ]);
                }
            }
        }

        if (isset($data['fasilitas']) && is_array($data['fasilitas'])) {
            $villa->fasilitas()->sync($data['fasilitas']);
        }

        return $villa;
    }
}
