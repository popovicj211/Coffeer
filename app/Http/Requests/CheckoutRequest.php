<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'city' => 'required|not_in:0',
            'street' => 'required|min:5|max:40',
            'place' => 'required|not_in:0',
            'postcode' => 'required|regex:/^[1-2](1)[0-9]{3}$/',
            'mobile' => 'required|regex:/^(06)[1-69](\s)[0-9]{3}(\s)[0-9]{3,4}$/',
            'paymethod' => 'required' ,
            'creditcardnumber' => 'required|unique:checkout,cardnumber|regex:/^[\d]{4}(\s)[\d]{4}(\s)[\d]{4}(\s)[\d]{4}$/'
        ];
    }

    public function messages()
    {
        return [
            'creditcardnumber.unique'  => 'Number of credit card exist.',
            'city.not_in'  => 'City is not selected.',
            'street.regex'  => 'Street is not valid.',
            'street.required'  => 'Street is empty.',
            'place.not_in'  => 'Place is not selected.',
            'postcode.required'  => 'Postcode is empty.',
            'postcode.regex'  => 'Postcode is not valid.',
            'mobile.required'  => 'Mobile is empty.',
            'mobile.regex'  => 'Mobile is not valid.',
             'paymethod.required' => 'Pay method is not checked.',
            'creditcardnumber.required' => 'Number of credit card is empty',
            'creditcardnumber.regex' => 'Number of credit card is not valid ',
        ];
    }
}
