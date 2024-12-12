<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please enter a name',
            'first_name.string' => 'Name can only text',
            'first_name.max' => 'Name must be maximum 255 characters',
            'last_name.required' => 'Please enter a surname',
            'last_name.string' => 'Surname can only text',
            'last_name.max' => 'Surname must be maximum 255 characters',
            'email.required' => 'Please enter an email address',
            'email.email' => 'Please enter a valid email address',
            'email.max' => 'Email address must be maximum 255 characters',
            'email.unique' => 'This email address is already registered',
            'password.required' => 'Please enter a password',
            'password.min' => 'The password must be at least 6 characters',
            'password.confirmed' => 'Your passwords do not match',
        ];
    }
}
