<?php

namespace App\Http\Controllers\Web;

use App\Domain\Notes\Actions\StoreNoteAction;
use App\Domain\Notes\Actions\UpdateNoteAction;
use App\Domain\Notes\Dtos\StoreNoteData;
use App\Domain\Notes\Dtos\UpdateNoteData;
use App\Domain\Notes\Exceptions\NoteExceptions;
use App\Domain\Subscriptions\Exceptions\SubscriptionExceptions;
use App\Domain\Notes\Models\Note;
use App\Domain\Users\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreNoteRequest;
use App\Http\Requests\Web\UpdateNoteRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

class NotesController extends Controller
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

    public function store(StoreNoteRequest $request): RedirectResponse
    {
        /** @var User $authUser */
        $authUser = $request->user();
        $data = StoreNoteData::fromRequest($request);

        try {
            (new StoreNoteAction())->handle($data, $authUser);
        } catch (NoteExceptions|SubscriptionExceptions $e) {
            return redirect()
                ->route('notes.index')
                ->with('warning', $e->getMessage());
        }

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

    public function update(UpdateNoteRequest $request, Note $note): RedirectResponse
    {
        $data = UpdateNoteData::fromRequest($request);

        (new UpdateNoteAction())->handle($note, $data);

        return redirect()->route('notes.index')->with('status', 'Note updated!!');
    }

    public function destroy(Note $note): RedirectResponse
    {
        $note->delete();

        return redirect()->route('notes.index')->with('status', 'Note deleted');
    }
}
