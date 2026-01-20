<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiUserProfileTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public'); // Fake the public disk for avatar uploads
    }

    public function test_authenticated_user_can_update_profile()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/update-profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Profile updated successfully.'])
                 ->assertJsonFragment(['name' => 'New Name', 'email' => 'new@example.com']);
        
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);
    }

    public function test_unauthenticated_user_cannot_update_profile()
    {
        $response = $this->postJson('/api/update-profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_upload_avatar()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100);

        $response = $this->postJson('/api/user/avatar', [
            'avatar' => $avatar,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Avatar updated successfully.']);
        
        Storage::disk('public')->assertExists('avatars/' . $avatar->hashName());
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => 'avatars/' . $avatar->hashName(),
        ]);
    }

    public function test_authenticated_user_can_replace_avatar()
    {
        $user = User::factory()->create([
            'avatar' => 'avatars/old_avatar.jpg',
        ]);
        Storage::disk('public')->put('avatars/old_avatar.jpg', 'dummy content');

        Sanctum::actingAs($user);

        $newAvatar = UploadedFile::fake()->image('new_avatar.png', 100, 100);

        $response = $this->postJson('/api/user/avatar', [
            'avatar' => $newAvatar,
        ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertExists('avatars/' . $newAvatar->hashName());
        Storage::disk('public')->assertMissing('avatars/old_avatar.jpg');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'avatar' => 'avatars/' . $newAvatar->hashName(),
        ]);
    }

    public function test_unauthenticated_user_cannot_upload_avatar()
    {
        $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100);

        $response = $this->postJson('/api/user/avatar', [
            'avatar' => $avatar,
        ]);

        $response->assertStatus(401);
    }
}
