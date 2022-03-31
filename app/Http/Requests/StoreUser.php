<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Rules\Password;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->currentTeam->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'birthDate' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:10','min:9'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password],
            'roles' => ['required', 'array'],
            'roles.*' => ['required','exists:teams,id'],
        ];
    }
}
