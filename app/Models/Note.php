<?php

namespace App\Models;

use App\QueryBuilders\NoteQueryBuilder;
use Database\Factories\NoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property int $user_id
 * @property string $title
 * @property string $content
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read string $excerpt
 * @property-read User $user
 *
 * @method static NoteFactory factory(...$parameters)
 * @method static NoteQueryBuilder query()
 */
class Note extends Model
{
    use HasFactory;

    protected $appends = ['excerpt'];

    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

    /**
     * @param Builder $query
     * @return NoteQueryBuilder<Note>
     */
    public function newEloquentBuilder($query): NoteQueryBuilder
    {
        return new NoteQueryBuilder($query);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit($this->content, 75);
    }
}
