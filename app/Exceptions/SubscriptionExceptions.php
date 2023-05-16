<?php

namespace App\Exceptions;

use Exception;

class SubscriptionExceptions extends Exception
{
    public static function userDoesNotHaveSubscription(): self
    {
        return new static(__('validation.custom.subscription.required'));
    }
}
