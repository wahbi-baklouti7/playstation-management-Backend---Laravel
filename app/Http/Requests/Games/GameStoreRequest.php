<?php

namespace App\Http\Requests\Games;

use Illuminate\Foundation\Http\FormRequest;

class GameStoreRequest extends FormRequest
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
            'name'=>'required' , 'min:3' , 'max:30' , 'unique:games',
            'price'=>'required' , 'numeric' , 'min:0' , 'max:100',
            'extra_time_price'=>'required' , 'numeric' , 'min:0' , 'max:100'
        ];
    }
}
