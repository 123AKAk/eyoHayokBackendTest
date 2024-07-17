<?php

namespace App\Policies;

use App\Models\Patients;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientsPolicy
{
    public function modify(User $user, Patients $post): Response
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny('You do not own this post');
    }
}
