<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product'=>'required|string|max:60|min:5',
            'price'=>'required|numeric',
            'description'=>'required|string|max:100|min:5',

        ];
    }
}
