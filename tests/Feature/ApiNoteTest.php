<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiNoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_show_and_update_own_note()
    {
        $user = User::factory()->create();
        $note = Note::create([
            'user_id' => $user->id,
            'content' => 'Original note',
        ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/notes/' . $note->id)
            ->assertOk()
            ->assertJsonFragment(['content' => 'Original note']);

        $this->patchJson('/api/notes/' . $note->id, [
            'content' => 'Updated note',
        ])
            ->assertOk()
            ->assertJsonFragment(['content' => 'Updated note']);

        $this->assertDatabaseHas('notes', [
            'id' => $note->id,
            'content' => 'Updated note',
        ]);
    }

    public function test_user_cannot_access_another_users_note()
    {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();
        $note = Note::create([
            'user_id' => $owner->id,
            'content' => 'Private note',
        ]);

        Sanctum::actingAs($otherUser);

        $this->getJson('/api/notes/' . $note->id)->assertForbidden();
        $this->patchJson('/api/notes/' . $note->id, [
            'content' => 'Changed note',
        ])->assertForbidden();
    }
}
