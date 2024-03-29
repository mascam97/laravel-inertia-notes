<?php

namespace Tests\Unit\Notes\Actions;

use App\Domain\Notes\Actions\UpdateNoteAction;
use App\Domain\Notes\Dtos\UpdateNoteData;
use App\Domain\Notes\Models\Note;
use App\Domain\Users\Models\User;
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
