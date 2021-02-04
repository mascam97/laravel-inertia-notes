<?php

namespace Tests\Unit\Models;

use App\Models\Note;
use PHPUnit\Framework\TestCase;

class NoteTest extends TestCase
{
    public function test_get_excerpt()
    {
        $note = new Note();
        $note->content = "Sunt quaerat eveniet hic voluptatem quod quibusdam voluptas. Cum iusto assumenda mollitia ea ut consequuntur. Labore ipsam voluptatem delectus libero ab deserunt. Recusandae ut quia rem quia qui dolorem soluta. Exercitationem saepe vel minus dolore et et maiores.";
        
        $this->assertEquals('Sunt quaerat eveniet hic voluptatem quod quibusdam voluptas. Cum iusto assu...', $note->excerpt);
    }
}
