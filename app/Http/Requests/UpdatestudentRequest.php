<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatestudentRequest extends FormRequest
{
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
            'name' => "required",
            'address' => "required",
            'gender' => "required",
            'NIK' => "required|numeric|unique:students,NIK,except,id|size:16",
            'phone' => "required|numeric",
            'email' => "required|email",
        ];
    }
}
