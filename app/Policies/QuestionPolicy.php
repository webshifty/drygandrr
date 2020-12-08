<?php

namespace App\Policies;

use App\Models\Questions;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function modify(User $user, Questions $question)
    {
        if ($user->is_admin) {
            return true;
        }

        return $user->work_country === $question->country;
    }
}
