<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Domain\Users\Models\User;
use App\Domain\Notes\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $url = 'api/notes';

    private User $user;

    private Note $note;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->note = Note::factory()->user($this->user)->create([
            'title' => 'Post to delete',
        ]);

        $this->actingAs($this->user);
    }

    public function test_destroy()
    {
        $this->deleteJson("$this->url/{$this->note->id}")
            ->assertStatus(200)
            ->assertJsonPath('message', 'Note deleted!!');

        $this->assertDatabaseMissing('notes', [
            'id' => $this->note->getKey(),
            'user_id' => $this->user->getKey(),
            'title' => 'post to delete'
        ]);
    }
}
