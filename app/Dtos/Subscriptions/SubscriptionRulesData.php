<?php

namespace App\Dtos\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRulesData
{
    public function __construct(
        public ?int $notesMaximumAmount,
    ) {
    }

    public static function fromArray(array $array): self
    {
        return new static(
            notesMaximumAmount: $array['notes_maximum_amount'],
        );
    }
}
