<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
{
    public function authorize()
    {
         return true;
    }
    public function rules()
    {
        return [
            'email' => 'email|required|exists:users,email',
            'password' => 'required'
        ];
    }
}
