<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordFormRequest extends FormRequest
{
    public function authorize()
    {
         return true;
    }

    public function rules()
    {
        return [
            'email' => 'email|required|exists:users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => "I'm sorry. We can't find this email in our records."
        ];
    }
}
