<?php

namespace App\Actions\Notes;

use App\Dtos\Notes\StoreNoteData;
use App\Exceptions\NoteExceptions;
use App\Models\Note;
use App\Models\User;

class StoreNoteAction
{
    /**
     * @throws NoteExceptions
     */
    public function handle(StoreNoteData $data, User $user): Note
    {
        $notesAmount = $user->notes()->count();
        $userSubscription = $user->subscription;

        if ($userSubscription === null){
            throw NoteExceptions::userDoesNotHaveSubscription();
        }

        if ($notesAmount >= $userSubscription->rules['notes_maximum_amount']){
            throw NoteExceptions::notesAmountLimit($notesAmount);
        }

        $note = New Note();
        $note->title = $data->title;
        $note->content = $data->content;
        $note->user()->associate($user);
        $note->save();

        return $note;
    }
}
