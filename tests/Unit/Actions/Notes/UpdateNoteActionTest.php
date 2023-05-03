<?php

namespace Tests\Unit\Actions\Notes;

use App\Actions\Notes\UpdateNoteAction;
use App\Dtos\Notes\UpdateNoteData;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateNoteActionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Note $note;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->note = Note::factory()->user($this->user)->create([
            'title' => 'Old title',
            'content' => 'Old content',
        ]);
    }

    public function test_can_update_the_title_note()
    {
        $data = new UpdateNoteData(title: 'New title');

        $note = (new UpdateNoteAction())->handle($this->note, $data);

        $this->assertEquals('New title', $note->title);
        $this->assertEquals('Old content', $note->content);
    }

    public function test_can_update_the_content_note()
    {
        $data = new UpdateNoteData(content: 'New content');

        $note = (new UpdateNoteAction())->handle($this->note, $data);

        $this->assertEquals('Old title', $note->title);
        $this->assertEquals('New content', $note->content);
    }
}
