<?php

namespace App\Actions\Notes;

use App\Dtos\Notes\UpdateNoteData;
use App\Models\Note;

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
