<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreNoteControllerTest extends TestCase
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

    public function test_validate_store()
    {
        $this->post($this->url, [
            'title' => '',
            'content' => ''
        ])->assertStatus(302)
            ->assertSessionHasErrors(['title', 'content']);
    }

    public function test_store()
    {
        $this->post($this->url, [
            'title' => 'title',
            'content' => 'content'
        ])->assertStatus(302);

        $this->assertDatabaseHas('notes', [
            'title' => 'title',
            'content' => 'content',
            'user_id' => $this->user->getKey(),
        ]);
    }
}
