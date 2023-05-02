<?php

namespace Tests\Unit\QueryBuilders;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserQueryBuilderTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_notes_by_user()
    {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();
        $filteredNote = Note::factory()->create(['user_id' => $userOne->getKey()]);
        $notFilteredNote = Note::factory()->create(['user_id' => $userTwo->getKey()]);

        $notes = Note::query()->whereUser($userOne)->get();

        $this->assertCount(1, $notes);
        $this->assertTrue($filteredNote->is($notes->first()));
        $this->assertFalse($notFilteredNote->is($notes->first()));
    }

    public function test_can_get_notes_by_contains()
    {
        $user = User::factory()->create();
        $noteOne = Note::factory()->create(['user_id' => $user->getKey()]);
        $noteTwo = Note::factory()->create(['title' => 'Yesterday thoughts', 'user_id' => $user->getKey()]);
        $noteThree = Note::factory()->create(['content' => 'Yesterday was a hard day', 'user_id' => $user->getKey()]);

        $queryOne = Note::query()->whereContains(null)->get();
        $this->assertCount(3, $queryOne);

        $queryTwo = Note::query()->whereContains('Yesterday')->get();
        $this->assertCount(2, $queryTwo);

        $queryThree = Note::query()->whereContains('thoughts')->get();
        $this->assertCount(1, $queryThree);
        $this->assertTrue($noteTwo->is($queryThree->first()));

        $queryFour = Note::query()->whereContains('hard day')->get();
        $this->assertCount(1, $queryFour);
        $this->assertTrue($noteThree->is($queryFour->first()));
    }
}
