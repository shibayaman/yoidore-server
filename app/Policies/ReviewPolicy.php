<?php

namespace App\Policies;

use App\Review;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Review $review)
    {
        return $user->id === $review->user_id;
    }
}
