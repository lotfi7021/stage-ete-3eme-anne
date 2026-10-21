<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'nom_de_la_societe' => 'required|string|max:255',
            'code_TVA' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => ['required', 'regex:/^\d{8}$/'],
            'Email' => 'required|email|max:255',
            'login' => 'required|string|max:255|unique:admins,login',
            'groupe' => 'required|string|max:255',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        ];
    }
}
