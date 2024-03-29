<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=> 'required|string|max:60',
            'lastname'=> 'required|string|max:60',
            'phone'=> 'required|int',
            'email'=> 'required|email',
        ];
    }
}
