<?php

namespace Tests\Traits;

use App\Models\User;

trait AuthHelpers
{
    /**
     * Sign in as a user.
     *
     * @param  \App\Models\User|null  $user
     * @return \App\Models\User
     */
    public function login($user = null)
    {
        $user = $user ?: User::factory()->create();
        
        $this->actingAs($user);
        
        return $user;
    }
}
