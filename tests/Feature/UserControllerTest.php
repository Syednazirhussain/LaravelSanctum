<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;

use Tests\TestCase;

use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Seed roles into the database.
     */
    protected function seedRoles()
    {
        // Create roles if they don't exist
        Role::firstOrCreate(['name' => 'Admin', 'code' => 'admin']);
        Role::firstOrCreate(['name' => 'Chef', 'code' => 'chef']);
        Role::firstOrCreate(['name' => 'Waiter', 'code' => 'waiter']);
        Role::firstOrCreate(['name' => 'Customer', 'code' => 'customer']);
    }

    /**
     * Seed users into the database.
     */
    protected function seedUsers()
    {
        // Assuming the roles have already been seeded and retrieved
        $adminRole = Role::where('name', 'Admin')->first();
        $chefRole = Role::where('name', 'Chef')->first();
        $waiterRole = Role::where('name', 'Waiter')->first();
        $customerRole = Role::where('name', 'Customer')->first();

        // Default profile image path
        $defaultProfileImage = 'profile-images/default.jpeg';

        // Define user data
        $users = [
            ['name' => 'Customer User 1', 'email' => 'customer1@example.com', 'password' => Hash::make('password'), 'role' => $customerRole],
            ['name' => 'Customer User 2', 'email' => 'customer2@example.com', 'password' => Hash::make('password'), 'role' => $customerRole],
            ['name' => 'Customer User 3', 'email' => 'customer3@example.com', 'password' => Hash::make('password'), 'role' => $customerRole],
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => Hash::make('password'), 'role' => $adminRole],
            ['name' => 'Chef User', 'email' => 'chef@example.com', 'password' => Hash::make('password'), 'role' => $chefRole],
            ['name' => 'Waiter User', 'email' => 'waiter@example.com', 'password' => Hash::make('password'), 'role' => $waiterRole],
        ];

        // Create users and assign roles and profiles
        foreach ($users as $userData) {
            // Create the user
            $user = User::create([
                'name'      => $userData['name'],
                'email'     => $userData['email'],
                'password'  => $userData['password'],
            ]);

            // Attach the role to the user
            $user->roles()->attach($userData['role']->id);

            // Create the user profile
            UserProfile::create([
                'user_id'       => $user->id,
                'profile_img'   => $defaultProfileImage,
            ]);
        }
    }

    protected function authenticateUser()
    {
        $this->seedRoles();
        $this->seedUsers();

        // Assuming the first user created is the one we want to authenticate
        $user = User::first();

        // Sanctum::actingAs sets the current authenticated user for the request
        Sanctum::actingAs($user, ['*']);
        
        return $user;
    }

    protected function setUp(): void
    {
        parent::setUp();
        // Setup code like seeding roles or other necessary data
    }

    /** @test */
    public function it_adds_a_device_token_for_the_authenticated_user()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user, 'api'); // Assuming you're using the 'api' guard
        $user = $this->authenticateUser();

        $data = [
            'type' => 'android', // or 'ios' or 'web'
            'token' => $this->faker->uuid,
        ];

        $response = $this->postJson('/api/user/device-token', $data);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Device token added successfully']);

        $this->assertDatabaseHas('device_tokens', [
            'user_id' => $user->id,
            'type' => $data['type'],
            'token' => $data['token'],
        ]);
    }

    /** @test */
    public function it_fails_to_add_a_device_token_with_invalid_data()
    {
        $user = $this->authenticateUser();

        // Missing 'type' and 'token'
        $response = $this->postJson('/api/user/device-token', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['type', 'token']);
    }

    /** @test */
    public function it_removes_a_device_token_for_the_authenticated_user()
    {
        $user = $this->authenticateUser();

        $deviceToken = $user->deviceTokens()->create([
            'type' => 'ios',
            'token' => $this->faker->uuid,
        ]);

        $data = [
            'type' => 'ios', // or 'ios' or 'web'
            'token' => $deviceToken->token
        ];

        $response = $this->deleteJson('/api/user/device-token', $data);

        // Correct way to access response data
        $responseContent = $response->getContent();
        echo $responseContent;

        $response->assertStatus(200)
            ->assertJson(['message' => 'Device token removed successfully']);

        $this->assertDatabaseMissing('device_tokens', [
            'id' => $deviceToken->id,
        ]);
    }

    /** @test */
    public function it_fails_to_remove_a_non_existent_device_token()
    {
        $user = $this->authenticateUser();

        $data = [
            'type' => 'ios', // or 'ios' or 'web'
            'token' => 'nonexistenttoken'
        ];

        $response = $this->deleteJson('/api/user/device-token', $data);

        $response->assertStatus(404)
            ->assertJson(['message' => 'Device token not found']);
    }

    /** @test */
    public function it_requires_authentication_to_add_and_remove_device_tokens()
    {
        // Test add device token
        $data = [
            'type' => 'android',
            'token' => $this->faker->uuid,
        ];

        $response = $this->postJson('/api/user/device-token', $data);
        $response->assertStatus(401);

        // Test remove device token
        $data = ['token' => $this->faker->uuid];

        $response = $this->deleteJson('/api/user/device-token', $data);
        $response->assertStatus(401);
    }
}
