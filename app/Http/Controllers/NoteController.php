<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\NoteRequest;
use Inertia\Response;

class NoteController extends Controller
{
    public function index(Request $request): Response
    {
        /** @var User $authUser */
        $authUser = $request->user();

        $notes = Note::query()
            ->select(['id', 'title', 'content'])
            ->whereUser($authUser)
            ->whereContains($request->input('q'))
            ->latest()
            ->get()
            ->append(['excerpt']);

        return Inertia::render('Notes/Index', [
            'notes' => $notes->toArray()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Notes/Create');
    }

    public function store(NoteRequest $request): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = $request->user();

        $notesAmount = $authUser->notes()->count();
        $userSubscription = $authUser->subscription;

        if ($userSubscription === null){
            return redirect()
                ->route('notes.index')
                ->with('warning', __('validation.custom.subscription.required'));
        }

        if ($notesAmount >= $userSubscription->rules['notes_maximum_amount']){
            return redirect()
                ->route('notes.index')
                ->with('warning', __(
                    'validation.custom.notes.limit',
                    ['amount' => $userSubscription->rules['notes_maximum_amount']]
                ));
        }

        $request->user()->notes()->create($request->all());

        return redirect()->route('notes.index')->with('status', 'Note created!!');
    }

    public function show(Note $note): Response
    {
        return Inertia::render('Notes/Show', compact('note'));
    }

    public function edit(Note $note): Response
    {
        return Inertia::render('Notes/Edit', compact('note'));
    }

    public function update(NoteRequest $request, Note $note): RedirectResponse
    {
        $note->update($request->all());

        return redirect()->route('notes.index')->with('status', 'Note updated!!');
    }

    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('notes.index')->with('status', 'Note deleted');
    }
}
