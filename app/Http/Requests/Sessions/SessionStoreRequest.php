<?php

namespace App\Http\Requests\Sessions;

use Illuminate\Foundation\Http\FormRequest;

class SessionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => 'required','integer',
            'start_time' => 'required','date',
            'end_time' => 'required','date',
            'user_id' => 'required','exists:users,id',
            'game_id' => 'required','exists:games,id',
            'device_id' => 'required','exists:devices,id',

        ];
    }
}
