<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prenom' => 'required|regex:/^[a-zA-Z]+$/|max:255',
            'nom' => 'required|regex:/^[a-zA-Z]+$/|max:255',
            'e_mail' => 'required|email|max:255',
        ];
        
    }
}
