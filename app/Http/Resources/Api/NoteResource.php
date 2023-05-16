<?php

namespace App\Http\Resources\Api;

use App\Domain\Notes\Models\Note;
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
            'content' => $this->content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
