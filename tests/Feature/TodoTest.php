<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\AuthHelpers;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase, AuthHelpers;

    /**
     * Test that authenticated users can access the dashboard.
     */
    public function test_authenticated_users_can_access_dashboard(): void
    {
        // Using the trait helper method
        $this->login();

        $response = $this->get('/dashboard');
        
        $response->assertStatus(200);
    }
    
    /**
     * Test that guests are redirected to login when accessing dashboard.
     */
    public function test_guests_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        
        $response->assertRedirect('/login');
    }
}
