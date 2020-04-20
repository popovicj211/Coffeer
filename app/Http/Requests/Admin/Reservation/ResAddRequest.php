<?php

namespace App\Http\Requests\Admin\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class ResAddRequest extends FormRequest
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
             'adminResAddUser' => 'required|not_in:0',
            'adminResAddDate' => 'required|date|after:tomorrow|date_format:Y-m-d',
            'adminResAddTime' => 'required|date_format:H:i',
            'adminResAddMobile' => array('required','unique:reservation,mobile' ,'regex:/^(\+381)((\s)|(\-)|(\/))?(6)[0-69]((\s)|(\-)|(\/))?[\d]{3}((\s)|(\-)|(\/))?[\d]{3,4}$/'),
            'adminResAddMessage' =>  'required|regex:/^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/'
        ];
    }

    public function messages()
    {
        return [
            'adminResAddUser.not_in'  => 'User is not selected.',
            'adminResAddDate.required'  => 'Date is empty.',
            'adminResAddTime.required'  => 'Time is empty.',
            'adminResAddDate.regex'  => 'Date is not valid.',
            'adminResAddTime.regex'  => 'Time is not valid.',
            'adminResAddMobile.required'  => 'Mobile is empty.',
            'adminResAddMessage.required'  => 'Message is empty.',
            'adminResAddMobile.regex'  => 'Mobile is not valid.',
            'adminResAddMessage.regex'  => 'Message is not valid.'
        ];
    }
}
