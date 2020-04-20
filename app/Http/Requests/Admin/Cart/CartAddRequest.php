<?php

namespace App\Http\Requests\Admin\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartAddRequest extends FormRequest
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
            'adminCartAddUser' => 'required|not_in:0',
            'adminCartAddProduct' => 'required|not_in:0',
             'adminCartAddQuantity' => 'required|not_in:0'
        ];
    }

    public function messages()
    {
        return [

            'adminCartAddUser.not_in'  => 'User is not selected.',
            'adminCartAddProduct.not_in'  => 'Product is not selected.',
            'adminCartAddQuantity.not_in'  => 'Quantity is not selected.'
        ];
    }
}
