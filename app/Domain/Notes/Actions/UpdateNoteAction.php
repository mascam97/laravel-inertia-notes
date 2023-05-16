<?php

namespace App\Domain\Notes\Actions;

use App\Domain\Notes\Dtos\UpdateNoteData;
use App\Domain\Notes\Models\Note;

class UpdateNoteAction
{
    public function handle(Note $note, UpdateNoteData $data): Note
    {
        if ($data->title) {
            $note->title = $data->title;
        }

        if ($data->content) {
            $note->content = $data->content;
        }

        $note->update();

        return $note;
    }
}
