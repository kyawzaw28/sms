<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassitemRequest extends FormRequest
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
            'name' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'course' => 'required',
            'starttime' => 'required',
            'endtime' => 'required',
            'lecturers'=>'required',
            'room' => 'required',
            'days' => 'required',
            'price' => 'required',
            'maxstudent' => 'required',
            'daytype' => 'required',
            'color' => [
            function ($attribute, $value, $fail) {
                if (strtolower($value) == '#000000') {
                    $fail('Please choose the '.$attribute.'.');
                }
            },
        ],
            'shortcode' => 'required',
        ];
    }
}
