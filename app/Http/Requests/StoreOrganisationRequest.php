<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrganisationRequest extends FormRequest
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
            'entreprise' => 'required|regex:/^[a-zA-Z0-9]+$/|max:255',
            'code_postal' => 'required|digits_between:1,10',
            'ville' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'statut' => 'required|string|max:255',
        ];
    }
}
