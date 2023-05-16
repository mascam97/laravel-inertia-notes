<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowNotesControllerTest extends TestCase
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
            'title' => 'Post to delete',
        ]);

        $this->actingAs($this->user);
    }

    public function test_show_and_edit()
    {
        $this->get("$this->url/{$this->note->id}")
            ->assertStatus(200)
            ->assertSee($this->note->title)
            ->assertSee($this->note->content);

        $this->get("$this->url/{$this->note->id}/edit")
            ->assertStatus(200)
            ->assertSee($this->note->title)
            ->assertSee($this->note->content);
    }
}
