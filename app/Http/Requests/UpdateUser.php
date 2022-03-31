<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class UpdateUser extends FormRequest
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
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'birthDate' => ['required', 'date'],
            'phone' => ['required', 'string', 'max:10','min:9'],
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Route::input('user'))],
            'password' => ['nullable', 'string', new Password],
            'roles' => ['required', 'array'],
            'roles.*' => ['required','exists:teams,id'],
        ];
    }

    public function validationData()
    {
        return array_merge($this->request->all(), [
            'id' => Route::input('user'),
        ]);
    }
}
