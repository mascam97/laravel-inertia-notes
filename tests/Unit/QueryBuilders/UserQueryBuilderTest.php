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
        $filteredNote = Note::factory()->user($userOne)->create();
        $notFilteredNote = Note::factory()->user($userTwo)->create();

        $notes = Note::query()->whereUser($userOne)->get();

        $this->assertCount(1, $notes);
        $this->assertTrue($filteredNote->is($notes->first()));
        $this->assertFalse($notFilteredNote->is($notes->first()));
    }

    public function test_can_get_notes_by_contains()
    {
        $user = User::factory()->create();
        $noteOne = Note::factory()->user($user)->create();
        $noteTwo = Note::factory()->user($user)->create(['title' => 'Yesterday thoughts']);
        $noteThree = Note::factory()->user($user)->create(['content' => 'Yesterday was a hard day']);

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
