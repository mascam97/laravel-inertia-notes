<?php

namespace App\Domain\Subscriptions\Exceptions;

use Exception;

class SubscriptionExceptions extends Exception
{
    public static function userDoesNotHaveSubscription(): self
    {
        return new self(__('validation.custom.subscription.required'));
    }
}
