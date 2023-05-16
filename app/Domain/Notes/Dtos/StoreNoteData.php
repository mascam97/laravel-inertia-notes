<?php

namespace App\Domain\Notes\Dtos;

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
        return new self(
            title: $request->input('title'),
            content: $request->input('content'),
        );
    }
}
