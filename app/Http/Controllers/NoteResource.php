<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Note;
 */
class NoteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
