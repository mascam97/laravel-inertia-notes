<?php

namespace Tests\Feature\Http\Controllers\Web\Notes;

use App\Domain\Subscriptions\Models\Subscription;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $url = '/notes';

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
        $this->post($this->url, [
            'title' => 'Title for the content',
            'content' => 'Content for the content'
        ])->assertStatus(302);

        $this->assertDatabaseHas('notes', [
            'title' => 'Title for the content',
            'content' => 'Content for the content',
            'user_id' => $this->user->getKey(),
        ]);
    }

    public function test_cannot_store_if_an_exception_is_thrown()
    {
        $this->user->subscription()->disassociate()->save();

        $this->post($this->url, [
            'title' => 'title',
            'content' => 'content'
        ])->assertStatus(302);

        $this->assertDatabaseMissing('notes', [
            'title' => 'title',
            'content' => 'content',
            'user_id' => $this->user->getKey(),
        ]);
    }
}
