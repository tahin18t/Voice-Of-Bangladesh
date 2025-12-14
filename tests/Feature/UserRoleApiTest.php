<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserRoleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_users()
    {
        // Create role and admin user
        $role = \App\Models\Role::factory()->create(['name' => 'admin']);
        $admin = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($admin, 'sanctum');

        $response = $this->getJson('/api/v1/admin/users');
        $response->assertStatus(200);
    }
}
