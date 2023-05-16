<?php

namespace App\Domain\Notes\Exceptions;

use Exception;

class NoteExceptions extends Exception
{
    public static function notesAmountLimit(int $limitNotes): self
    {
        return new self(__('validation.custom.notes.limit', ['amount' => $limitNotes]));
    }
}
