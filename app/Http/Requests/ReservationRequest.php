<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
              'resdate' => 'required|date|after:tomorrow|date_format:Y-m-d',
              'restime' => 'required|date_format:H:i',
              'resmob' => array('required','unique:reservation,mobile' ,'regex:/^(\+381)((\s)|(\-)|(\/))?(6)[0-69]((\s)|(\-)|(\/))?[\d]{3}((\s)|(\-)|(\/))?[\d]{3,4}$/'),
            'resmsg' =>  'required|regex:/^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/'
        ];
    }

    public function messages()
    {
        return [

            'resdate.required'  => 'Date is empty.',
            'restime.required'  => 'Time is empty.',
            'resdate.regex'  => 'Date is not valid.',
            'restime.regex'  => 'Time is not valid.',
            'resmob.required'  => 'Mobile is empty.',
            'resmsg.required'  => 'Message is empty.',
              'resmob.regex'  => 'Mobile is not valid.',
            'resmsg.regex'  => 'Message is not valid.'
        ];
    }

}
