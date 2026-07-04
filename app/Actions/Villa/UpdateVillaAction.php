<?php

namespace App\Actions\Villa;

use App\Models\Villa;
use Illuminate\Support\Facades\Storage;

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
        $updateData = [
            'pemilik_id' => $data['pemilik_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'address' => $data['address'] ?? null,
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'persenan_pengelola' => $data['persenan_pengelola'],
            'persenan_pemilik' => $data['persenan_pemilik'],
        ];

        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($villa->image) {
                Storage::disk('public')->delete($villa->image);
            }
            $updateData['image'] = $data['image']->store('villas', 'public');
        }

        $villa->update($updateData);

        // Update Rooms (recreate)
        $villa->rooms()->delete();
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

        // Sync Fasilitas
        if (isset($data['fasilitas']) && is_array($data['fasilitas'])) {
            $villa->fasilitas()->sync($data['fasilitas']);
        } else {
            $villa->fasilitas()->sync([]);
        }

        // Handle Gallery: delete marked images, then add new ones
        if (isset($data['deleted_galleries']) && is_array($data['deleted_galleries'])) {
            $toDelete = $villa->galleries()->whereIn('id', $data['deleted_galleries'])->get();
            foreach ($toDelete as $galleryItem) {
                Storage::disk('public')->delete($galleryItem->image);
                $galleryItem->delete();
            }
        }

        if (isset($data['gallery']) && is_array($data['gallery'])) {
            foreach ($data['gallery'] as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    $path = $image->store('villas/gallery', 'public');
                    $villa->galleries()->create(['image' => $path]);
                }
            }
        }

        return $villa;
    }
}
