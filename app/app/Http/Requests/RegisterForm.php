<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterForm extends FormRequest
{
    use ApiRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
