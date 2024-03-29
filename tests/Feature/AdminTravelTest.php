<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminTravelTest extends TestCase
{

    use RefreshDatabase;

    public function test_public_user_cannot_access_adding_travel()
    {
        $this->postJson( '/api/v1/admin/travels' )->assertStatus( 401 );
    }

    public function test_non_admin_user_cannot_access_adding_travel()
    {

        $this->seed( RoleSeeder::class );
        $user = User::factory()->create();
        $user->roles()->attach( Role::where('name', 'editor')->value("id") );

        $this->actingAs($user)->postJson('/api/v1/admin/travels')->assertStatus(403);

    }

    public function test_saves_travel_successfully_with_valid_data()
    {

        $this->seed( RoleSeeder::class );
        $user = User::factory()->create();
        $user->roles()->attach( Role::where('name', 'admin')->value("id") );

        $this->actingAs($user)
            ->postJson(
                '/api/v1/admin/travels',
                [ "name" => "travelName" ]
            )
            ->assertStatus(422);


        $this->actingAs($user)
            ->postJson(
                '/api/v1/admin/travels',
                [
                    "name" => "travelName",
                    'is_public' => 1,
                    'description' => 'Some Description',
                    'number_of_days' => 5
                ]
            )
            ->assertStatus(201);

        $this->get( '/api/v1/travels' )
            ->assertJsonFragment( ['name' => 'travelName'] );

    }

}
