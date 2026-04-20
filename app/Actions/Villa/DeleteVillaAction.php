<?php

namespace App\Actions\Villa;

use App\Models\Villa;

class DeleteVillaAction
{
    /**
     * Delete a Villa.
     *
     * @param Villa $villa
     * @return bool|null
     */
    public function execute(Villa $villa): ?bool
    {
        return $villa->delete();
    }
}
