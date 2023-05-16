<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateNoteValidationsControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/notes';

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

    public function test_validate_update()
    {
        $this->put("$this->url/{$this->note->getKey()}", [
            'title' => 'title',
            'content' => 'content'
        ])->assertStatus(302)
        ->assertSessionHasErrors(['title', 'content']);
    }
}
