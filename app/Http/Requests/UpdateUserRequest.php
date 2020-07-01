<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "string",
            "lastname" => "string",
            "address" => "string",
            "phone" => "string|unique:users,email," . $this->id,
            "birthday" => "date",
            "email" => "email|string|unique:users,email," . $this->id,
            "password" => "min:8|confirmed",
        ];
    }
}
