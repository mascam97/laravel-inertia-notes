<?php

namespace App\QueryBuilders;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class NoteQueryBuilder  extends Builder
{
    public function whereUser(User $user): self
    {
        return $this->where('user_id', $user->getKey());
    }

    public function whereContains(?string $keyword): self
    {
        if ($keyword === null){
            return $this;
        }

        return $this->where('title', 'like', "%$keyword%")
            ->orWhere('content', 'like', "%$keyword%");
    }
}
