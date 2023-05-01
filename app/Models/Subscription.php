<?php

namespace App\Models;

use Database\Factories\SubscriptionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property-read int $id
 * @property string $name
 * @property array $rules
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read Collection $users
 *
 * @method static SubscriptionFactory factory(...$parameters)
 */
class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rules'
    ];

    protected $casts = [
        'rules' => 'array',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
