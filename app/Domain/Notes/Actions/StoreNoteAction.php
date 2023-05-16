<?php

namespace App\Domain\Notes\Actions;

use App\Domain\Notes\Dtos\StoreNoteData;
use App\Domain\Subscriptions\Dtos\SubscriptionRulesData;
use App\Domain\Notes\Exceptions\NoteExceptions;
use App\Domain\Notes\Models\Note;
use App\Domain\Subscriptions\Exceptions\SubscriptionExceptions;
use App\Domain\Users\Models\User;

class StoreNoteAction
{
    /**
     * @throws NoteExceptions
     * @throws SubscriptionExceptions
     */
    public function handle(StoreNoteData $data, User $user): Note
    {
        $userSubscription = $user->subscription;

        if ($userSubscription === null) {
            throw SubscriptionExceptions::userDoesNotHaveSubscription();
        }

        $notesAmount = $user->notes()->count();
        $subscriptionRulesData = SubscriptionRulesData::fromArray($userSubscription->rules);

        if ($notesAmount >= $subscriptionRulesData->notesMaximumAmount) {
            throw NoteExceptions::notesAmountLimit($notesAmount);
        }

        $note = new Note();
        $note->title = $data->title;
        $note->content = $data->content;
        $note->user()->associate($user);
        $note->save();

        return $note;
    }
}
