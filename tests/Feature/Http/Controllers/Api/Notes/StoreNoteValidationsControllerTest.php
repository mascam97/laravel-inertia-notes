<?php

namespace Tests\Feature\Http\Controllers\Api\Notes;

use App\Domain\Notes\Models\Note;
use App\Domain\Subscriptions\Models\Subscription;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNoteValidationsControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $url = 'api/notes';

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

    public function test_validate_required_data()
    {
        $this->postJson($this->url, [])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => ['The title field is required.'],
                'content' => ['The content field is required.']
            ]);
    }

    public function test_validate_min_and_max_data()
    {
        $this->postJson($this->url, [
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

        $this->postJson($this->url, [
            'title' => 'A unique title for note',
            'content' => 'Content fot the note'
        ])->assertStatus(422)
            ->assertJsonValidationErrors([
                'title' => ['The title has already been taken.'],
            ]);
    }
}
