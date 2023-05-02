<?php

namespace App\Exceptions;

use Exception;

class NoteExceptions extends Exception
{
    public static function notesAmountLimit(int $limitNotes): self
    {
        return new static(__('validation.custom.notes.limit', ['amount' => $limitNotes]));
    }

    public static function userDoesNotHaveSubscription(): self
    {
        return new static(__('validation.custom.subscription.required'));
    }
}
