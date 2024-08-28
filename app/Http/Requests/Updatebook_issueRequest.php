<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Updatebook_issueRequest extends FormRequest
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
            'issue_date' => 'required',
            'return_date' => 'required',
            'return_day' => 'required',
            'student_id' => 'required',
            'book_id' => 'required'
        ];
    }
}
