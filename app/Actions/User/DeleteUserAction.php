<?php

namespace App\Actions\User;

use App\Models\User;

class DeleteUserAction
{
    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool|null
     */
    public function execute(User $user): ?bool
    {
        return $user->delete();
    }
}
