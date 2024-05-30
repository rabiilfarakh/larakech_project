<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prenom' => 'required|regex:/^[a-zA-Z]+$/|max:255',
            'nom' => 'required|regex:/^[a-zA-Z]+$/|max:255',
            'e-mail' => 'required|email|max:255',
            'organisation_id' => 'required|integer',
            // 'telephone_fixe' => 'required',
            // 'service' => 'required',
            // 'fonction' => 'required', 
        ];
        
    }
}

