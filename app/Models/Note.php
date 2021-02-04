<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Note extends Model
{
    use HasFactory;
 
    protected $appends = ['excerpt'];

    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->content, 75);
    }
}
