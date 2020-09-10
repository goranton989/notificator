<?php

namespace App\Http\Requests;

use App\Http\Requests\Traits\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreMessage extends FormRequest
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
            'message' => 'required|max:255',
        ];
    }
}
