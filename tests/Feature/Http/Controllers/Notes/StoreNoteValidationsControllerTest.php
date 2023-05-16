<?php

namespace Tests\Feature\Http\Controllers\Notes;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNoteValidationsControllerTest extends TestCase
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

    public function test_validate_store()
    {
        $this->post($this->url, [
            'title' => '',
            'content' => ''
        ])->assertStatus(302)
            ->assertSessionHasErrors(['title', 'content']);
    }
}
