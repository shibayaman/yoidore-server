<?php

namespace App\Policies;

use App\Parameter;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParameterPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Parameter $parameter)
    {
        return $parameter->user_id === $user->id;
    }
}
