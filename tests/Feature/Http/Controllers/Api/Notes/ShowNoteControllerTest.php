<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowNoteControllerTest extends TestCase
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
            'title' => 'Post to show',
        ]);

        $this->actingAs($this->user);
    }

    public function test_show()
    {
        $this->getJson("$this->url/{$this->note->id}")
            ->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $data) {
                    $data->where('id', $this->note->id)
                    ->where('title', $this->note->title)
                    ->where('content', $this->note->content)
                    ->where('excerpt', $this->note->excerpt)
                    ->has('created_at')
                    ->has('updated_at');
                })->etc();
            });
    }
}
