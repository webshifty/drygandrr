<?php

namespace App\Policies;

use App\Models\QAndA;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    public function changeResponsible(QAndA $request, User $user)
    {
        if ($user->is_admin) {
            return true;
        }

        return !$request->responsible_user_id;
    }
}
