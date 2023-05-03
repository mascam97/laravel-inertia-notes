<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexNotesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $url = "/notes";

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->actingAs($this->user);
    }

    public function test_index_empty()
    {
        $this->get($this->url)
            ->assertStatus(200)
            ->assertSee(htmlspecialchars_decode('notes&quot;:[]'));
    }

    public function test_index_notes()
    {
        $note = Note::factory()->user($this->user)->create();

        $this->get($this->url)
            ->assertStatus(200)
            ->assertSee($note->title)
            ->assertSee($this->user->name)
            ->assertDontSee(htmlspecialchars_decode('notes&quot;:[]'));
    }

    public function test_filter_by_title()
    {
        $filteredNote = Note::factory()->user($this->user)->create([
            'title' => 'Task for weekend',
        ]);

        $notFilteredNote = Note::factory()->user($this->user)->create([
            'title' => 'Task for monday',
        ]);

        $this->get("$this->url?q=weekend")
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

        $this->get("$this->url?q=tomorrow")
            ->assertStatus(200)
            ->assertSee($filteredNote->title)
            ->assertDontSee($notFilteredNote->title);
    }
}
