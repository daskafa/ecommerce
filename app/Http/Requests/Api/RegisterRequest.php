<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'identity' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'identity.required' => 'Please enter your identity number.',
            'identity.numeric' => 'Your identity number must be a numeric value.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address you provided is already in use.',
            'phone.required' => 'Please enter your phone number.',
            'password.required' => 'Please enter a password.',
            'password.confirmed' => 'Please make sure the password confirmation matches.',
            'password.min' => 'Your password must be at least 6 characters long.',
        ];
    }
}
