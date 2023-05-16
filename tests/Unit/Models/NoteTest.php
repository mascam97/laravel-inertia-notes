<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    public function test_belongs_to_note()
    {
        $note = Note::factory()->user(User::factory()->create())->create();

        $this->assertInstanceOf(User::class, $note->user);
    }

    public function test_get_excerpt()
    {
        $note = new Note();
        $note->content = 'Sunt quaerat eveniet hic voluptatem quod quibusdam voluptas. Cum iusto assumenda mollitia ea ut consequuntur. Labore ipsam volupt.';

        $this->assertEquals('Sunt quaerat eveniet hic voluptatem quod quibusdam voluptas. Cum iusto assu...', $note->excerpt);
    }
}
