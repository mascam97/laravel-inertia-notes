<?php

namespace App\Http\Controllers\Api;

use App\Actions\Notes\StoreNoteAction;
use App\Actions\Notes\UpdateNoteAction;
use App\Dtos\Notes\StoreNoteData;
use App\Dtos\Notes\UpdateNoteData;
use App\Exceptions\NoteExceptions;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NoteResource;
use App\Http\Requests\UpdateNoteRequest;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\StoreNoteRequest;

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
        } catch (NoteExceptions $e) {
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
