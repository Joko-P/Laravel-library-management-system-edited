<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorestudentRequest extends FormRequest
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
            'name' => "required|min:3|string",
            'address' => "required|string|min:5",
            'gender' => "required",
            'NIK' => "required|digits:16|unique:students,NIK,except,id",
            'phone' => "required|digits_between:8,13",
            'email' => "required|email:dns",
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Nama minimal 3 karakter!',
            'address.min' => 'Alamat minimal 5 karakter!',
            'NIK.digits' => 'NIK harus 16 digit numerik!',
            'NIK.unique' => 'NIK sudah terdaftar!',
            'phone.digits_between' => 'Nomor telepon harus 8 - 13 digit numerik!',
            'email.email' => 'E-mail tidak valid / gagal uji DNS!'
        ];
    }
}
