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
        $note = Note::factory()->create([
            'user_id' => User::factory()->create()
        ]);

        $this->assertInstanceOf(User::class, $note->user);
    }

    public function test_get_excerpt()
    {
        $note = new Note();
        $note->content = "Sunt quaerat eveniet hic voluptatem quod quibusdam voluptas. Cum iusto assumenda mollitia ea ut consequuntur. Labore ipsam voluptatem delectus libero ab deserunt. Recusandae ut quia rem quia qui dolorem soluta. Exercitationem saepe vel minus dolore et et maiores.";
        
        $this->assertEquals('Sunt quaerat eveniet hic voluptatem quod quibusdam voluptas. Cum iusto assu...', $note->excerpt);
    }
}
