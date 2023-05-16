<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Domain\Notes\Models\Note;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateNoteValidationsControllerTest extends TestCase
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
            'title' => 'Note title',
            'content' => 'Note content',
        ]);

        $this->actingAs($this->user);
    }

    public function test_validate_min_and_max_data()
    {
        $this->putJson("$this->url/{$this->note->getKey()}", [
            'title' => 'title',
            'content' => 'content'
        ])->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => ['The title must be at least 6 characters.'],
                'content' => ['The content must be at least 20 characters.']
            ]);
    }

    public function test_validate_title_should_be_unique()
    {
        Note::factory()->user($this->user)->create([
            'title' => 'A unique title for note'
        ]);

        $this->putJson("$this->url/{$this->note->getKey()}", [
            'title' => 'A unique title for note',
            'content' => 'Content fot the note'
        ])->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => ['The title has already been taken.'],
            ]);
    }
}
