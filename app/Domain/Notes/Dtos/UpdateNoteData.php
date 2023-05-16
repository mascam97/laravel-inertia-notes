<?php

namespace App\Domain\Notes\Dtos;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoteData
{
    public function __construct(
        public ?string $title = null,
        public ?string $content = null,
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
