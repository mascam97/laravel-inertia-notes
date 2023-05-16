<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Domain\Users\Models\User;
use App\Domain\Notes\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexNotesControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $url = 'api/notes';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Note::factory(10)->user($this->user)->create();

        $this->actingAs($this->user, 'sanctum');
    }

    public function test_index_notes()
    {
        $this->getJson($this->url)
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                    'created_at',
                    'updated_at',
                ]
            ]]);
    }

    public function test_filter_by_title()
    {
        $filteredNote = Note::factory()->user($this->user)->create([
            'title' => 'Task for weekend',
        ]);

        $notFilteredNote = Note::factory()->user($this->user)->create([
            'title' => 'Task for monday',
        ]);

        $this->getJson("$this->url?q=weekend")
            ->assertStatus(200)
            ->assertSee($filteredNote->title)
            ->assertDontSee($notFilteredNote->title);
    }

    public function test_filter_by_content()
    {
        $filteredNote = Note::factory()->user($this->user)->create([
            'content' => 'Tomorrow I should',
        ]);

        $notFilteredNote = Note::factory()->user($this->user)->create([
            'content' => 'Yesterday I did',
        ]);

        $this->getJson("$this->url?q=tomorrow")
            ->assertStatus(200)
            ->assertSee($filteredNote->title)
            ->assertDontSee($notFilteredNote->title);
    }
}
