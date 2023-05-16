<?php

namespace Tests\Unit\Notes\Actions;

use App\Domain\Notes\Actions\StoreNoteAction;
use App\Domain\Notes\Dtos\StoreNoteData;
use App\Domain\Notes\Exceptions\NoteExceptions;
use App\Domain\Subscriptions\Exceptions\SubscriptionExceptions;
use App\Domain\Notes\Models\Note;
use App\Domain\Subscriptions\Models\Subscription;
use App\Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreNoteActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Subscription $subscription;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->subscription = Subscription::factory()->create(['rules' => ['notes_maximum_amount' => 1000]]);
        $this->user->subscription()->associate($this->subscription)->save();
    }

    public function test_can_store_a_note()
    {
        $data = new StoreNoteData(title: 'Note title', content: 'Note content');

        $note = (new StoreNoteAction())->handle($data, $this->user);

        $this->assertEquals('Note title', $note->title);
        $this->assertEquals('Note content', $note->content);
        $this->assertTrue($note->user()->is($this->user));
    }

    public function test_cannot_store_if_user_does_not_have_subscription()
    {
        $this->expectException(SubscriptionExceptions::class);
        $this->expectExceptionMessage('You do not have a subscription associated, please contact the support team');
        $this->user->subscription()->disassociate()->save();

        $data = new StoreNoteData(title: 'Note title', content: 'Note content');

        (new StoreNoteAction())->handle($data, $this->user);
    }

    public function test_cannot_store_if_reaches_the_notes_limit_amount()
    {
        $this->expectException(NoteExceptions::class);
        $this->expectExceptionMessage('You cannot create more notes, you have reached the limit (100)');

        $this->subscription->update(['rules' => ['notes_maximum_amount' => 100]]);
        Note::factory(100)->user($this->user)->create();

        $data = new StoreNoteData(title: 'Note title', content: 'Note content');

        (new StoreNoteAction())->handle($data, $this->user);
    }
}
