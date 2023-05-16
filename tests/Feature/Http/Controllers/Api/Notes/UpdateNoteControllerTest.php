<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateNoteControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private string $url = 'api/notes';

    private User $user;

    private Note $note;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->note = Note::factory()->user($this->user)->create([
            'title' => 'Note title',
            'content' => 'Note content',
        ]);

        $this->actingAs($this->user);
    }

    public function test_update()
    {
        $this->putJson("$this->url/{$this->note->getKey()}", [
            'title' => 'New title for the note',
            'content' => 'New content for the note'
        ])->assertStatus(200)
            ->assertJsonPath('message', 'Note updated!!');

        $this->assertDatabaseHas('notes', [
            'id' => $this->note->getKey(),
            'title' => 'New title for the note',
            'content' => 'New content for the note',
            'user_id' => $this->user->getKey()
        ]);
    }
}
