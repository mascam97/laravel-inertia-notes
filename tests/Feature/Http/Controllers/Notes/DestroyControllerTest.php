<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyControllerTest extends TestCase
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

    public function test_destroy()
    {
        $this->delete("$this->url/{$this->note->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('notes', [
            'id' => $this->note->id,
            'user_id' => $this->note->user_id,
            'title' => 'post to delete'
        ]);
    }
}
