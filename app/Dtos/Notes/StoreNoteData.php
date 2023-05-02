<?php

namespace App\Dtos\Notes;

use Illuminate\Foundation\Http\FormRequest;

class StoreNoteData
{
    public function __construct(
        public string $title,
        public string $content,
    ) {
    }

    public static function fromRequest(FormRequest $request): self
    {
        return new static(
            title: $request->input('title'),
            content: $request->input('content'),
        );
    }
}
