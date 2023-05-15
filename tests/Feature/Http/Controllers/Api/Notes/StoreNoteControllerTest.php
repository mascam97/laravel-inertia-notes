<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreNoteControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    private string $url = "api/notes";

    private User $user;

    private Subscription $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->subscription = Subscription::factory()->create(['rules' => ['notes_maximum_amount' => 1000]]);
        $this->user->subscription()->associate($this->subscription)->save();

        $this->actingAs($this->user);
    }

    public function test_store()
    {
        $this->postJson($this->url, [
            'title' => 'Title for the note',
            'content' => 'Content for the note'
        ])->assertStatus(200)
            ->assertJsonPath('message', 'Note created!!');

        $this->assertDatabaseHas('notes', [
            'title' => 'Title for the note',
            'content' => 'Content for the note',
            'user_id' => $this->user->getKey(),
        ]);
    }

    public function test_cannot_store_if_an_exception_is_thrown()
    {
        $this->user->subscription()->disassociate()->save();

        $this->postJson($this->url, [
            'title' => 'Title for the note',
            'content' => 'Content for the note'
        ])->assertStatus(400)
            ->assertJsonPath('message', 'You do not have a subscription associated, please contact the support team');

        $this->assertDatabaseMissing('notes', [
            'title' => 'Title for the note',
            'content' => 'Content for the note',
            'user_id' => $this->user->getKey(),
        ]);
    }
}
