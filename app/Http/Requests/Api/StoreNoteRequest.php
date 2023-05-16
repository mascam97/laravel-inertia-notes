<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreNoteRequest extends FormRequest
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

        return [
            'title' => [
                'bail',
                'required',
                'string',
                'max:40',
                'min:6',
                Rule::unique('notes')
                    ->where('user_id', $authUserId)
            ],
            'content' => [
                'bail',
                'required',
                'string',
                'min:20'
            ],
        ];
    }
}
