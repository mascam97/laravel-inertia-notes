<?php

namespace App\Http\Requests;

use App\Models\Note;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var int $authUserId */
        $authUserId = Auth::id();
        /** @var Note $note */
        $note = $this->route('note');

        return [
            'title' => [
                'bail',
                'nullable',
                'string',
                'max:40',
                'min:6',
                Rule::unique('notes')
                    ->where('user_id', $authUserId)
                    ->ignoreModel($note)
            ],
            'content' => [
                'bail',
                'nullable',
                'string',
                'min:20'
            ],
        ];
    }
}
