<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner' => 'required',
            'category' => 'required',
            'type' => 'required',
            'sale_value' => 'required_if:venda,on:exibivalores,1',
            'rental_value' => 'required_if:locacao,on:exibivalores,1',
            'description' => 'nullable|min:3',
            'zipcode' => 'required|min:8|max:10',
            'state' => 'required',
            'city' => 'required',            
            'dormitories' => 'required',
            'title' => 'required'
        ];
    }
}
