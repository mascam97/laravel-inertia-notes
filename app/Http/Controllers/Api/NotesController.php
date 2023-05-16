<?php

namespace App\Http\Controllers\Api;

use App\Domain\Notes\Actions\StoreNoteAction;
use App\Domain\Notes\Actions\UpdateNoteAction;
use App\Domain\Notes\Dtos\StoreNoteData;
use App\Domain\Notes\Dtos\UpdateNoteData;
use App\Domain\Notes\Exceptions\NoteExceptions;
use App\Domain\Subscriptions\Exceptions\SubscriptionExceptions;
use App\Domain\Notes\Models\Note;
use App\Domain\Users\Models\User;
use App\Http\Requests\Api\StoreNoteRequest;
use App\Http\Requests\Api\UpdateNoteRequest;
use App\Http\Resources\Api\NoteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Controller;

class NotesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $authUser */
        $authUser = $request->user();

        $notes = Note::query()
            ->select(['id', 'title', 'content', 'created_at', 'updated_at'])
            ->whereUser($authUser)
            ->whereContains($request->input('q'))
            ->latest()
            ->get()
            ->append(['excerpt']);

        return response()->json([
            'data' => NoteResource::collection($notes)
        ]);
    }

    public function store(StoreNoteRequest $request): JsonResponse
    {
        /** @var User $authUser */
        $authUser = $request->user();
        $data = StoreNoteData::fromRequest($request);

        try {
            $note = (new StoreNoteAction())->handle($data, $authUser);
        } catch (NoteExceptions|SubscriptionExceptions $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

        return response()->json([
            'message' => 'Note created!!',
            'data' => NoteResource::make($note)
        ]);
    }

    public function show(Note $note): JsonResponse
    {
        return response()->json(['data' => NoteResource::make($note)]);
    }

    public function update(UpdateNoteRequest $request, Note $note): JsonResponse
    {
        $data = UpdateNoteData::fromRequest($request);

        $note = (new UpdateNoteAction())->handle($note, $data);

        return response()->json([
            'message' => 'Note updated!!',
            'data' => NoteResource::make($note)
        ]);
    }

    public function destroy(Note $note): JsonResponse
    {
        $note->delete();

        return response()->json(['message' => 'Note deleted!!']);
    }
}
