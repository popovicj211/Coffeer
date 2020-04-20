<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'contactname' => 'required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,13})$/' ,
            'contactemail' => 'required|email|unique:user,email|max:60',
            'contactsubject' => 'required|regex:/^[\w\s]{3,30}$/',
            'contactmsg' => 'required|regex:/^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/'
        ];
    }

    public function messages()
    {
        return [
            'contactemail.unique'  => 'Email exist.',
            'contactname.required'  => 'Name is not valid.',
            'contactemail.required'  => 'Email is not valid.',
            'contactsubject.required'  => 'Subject is not valid.',
            'contactmsg.required'  => 'Message is not valid.'
        ];
    }
}
