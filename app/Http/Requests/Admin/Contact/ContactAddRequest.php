<?php

namespace App\Http\Requests\Admin\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactAddRequest extends FormRequest
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
            'adminContactAddName' => 'required|regex:/^[A-ZŠĐČĆŽ][a-zšđčćž]{2,13}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,13})$/',
            'adminContactAddEmail' => 'required|regex:/^[\w]+[\.\_\-\w\d]*\@(gmail\.com)$/',
            'adminContactAddSubject' => 'required|regex:/^[A-ZŠĐČĆŽa-zšđčćž\d\s\.\:\;\,\*\+\?\!\-\_\/]{5,}$/',
            'adminContactAddMessage' => 'required|regex:/^[\w\s]{3,30}$/'
        ];
    }

    public function messages()
    {
        return [

            'adminContactAddName.regex' => 'Name is not valid.',
            'adminContactAddEmail.regex' => 'Email is not valid.',
            'adminContactAddName.required' => 'Name is empty.',
            'adminContactAddEmail.required' => 'Email is empty.',
            'adminContactAddSubject.regex'  => 'Subject is not valid.',
            'adminContactAddMessage.regex'  => 'Message is not valid.',
            'adminContactAddSubject.required'  => 'Subject is empty.',
            'adminContactAddMessage.required'  => 'Message is empty.',
        ];
    }
}
