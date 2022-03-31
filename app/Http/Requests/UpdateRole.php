<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UpdateRole extends FormRequest
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
            'id' => ['required','exists:teams,id'],
            'name' => ['required','max:255'],
            'is_admin' => ['boolean'],
            'is_default' => ['boolean'],
        ];
    }

    public function validationData()
    {
        return array_merge($this->request->all(), [
            'id' => Route::input('role'),
        ]);
    }
}
