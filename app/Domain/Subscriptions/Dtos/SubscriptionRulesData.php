<?php

namespace App\Domain\Subscriptions\Dtos;

class SubscriptionRulesData
{
    public function __construct(
        public ?int $notesMaximumAmount,
    ) {
    }

    public static function fromArray(array $array): self
    {
        return new self(
            notesMaximumAmount: $array['notes_maximum_amount'],
        );
    }
}
