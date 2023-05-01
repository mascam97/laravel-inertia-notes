<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateNoteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $url = "/notes";

    private User $user;

    private Note $note;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->note = Note::factory()->create([
            'title' => 'Note title',
            'content' => 'Note content',
            'user_id' => $this->user->getKey()
        ]);

        $this->actingAs($this->user);
    }

    public function test_validate_update()
    {
        $this->put("$this->url/{$this->note->getKey()}", [
            'title' => '',
            'content' => ''
        ])->assertStatus(302)
        ->assertSessionHasErrors(['title', 'content']);
    }

    public function test_update()
    {
        $this->put("$this->url/{$this->note->getKey()}", [
            'title' => 'New title',
            'content' => 'New content'
        ])->assertStatus(302);

        $this->assertDatabaseHas('notes', [
            'id' => $this->note->getKey(),
            'title' => 'New title',
            'content' => 'New content',
            'user_id' => $this->user->getKey()
        ]);
    }
}
