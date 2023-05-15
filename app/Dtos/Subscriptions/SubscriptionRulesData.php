<?php

namespace App\Dtos\Subscriptions;

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
