<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|unique:students,name|min:3',
            'address' => 'required|min:15',
            'email' => 'required|email|string|max:255|unique:students,email,',
            'phone' => 'required|numeric',
            'class_id'=> 'exists:classitems,id'
        ];
    }
}
