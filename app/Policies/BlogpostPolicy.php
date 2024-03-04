<?php

namespace App\Policies;

use App\Models\Blogpost;
use App\Models\User;

class BlogpostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(Blogpost $blogpost, User $user) {
        return $blogpost->user_id === $user->id;
    }
}
