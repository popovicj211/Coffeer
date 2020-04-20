<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
                'insPhotoProduct' => 'required|file|mimes:jpg,jpeg,png|max:2000',
                 'adminProductAddName' => 'required|min:4|max:50',
                  'adminProductAddDesc' => 'required|min:10',
                  'adminProductAddPrice' => 'required|regex:/^[\d]{1,5}(\.)[\d]{2}$/',
               //   'adminProductAddDiscount'=> 'required',
                  'adminProductAddCat' => 'required|not_in:0'
        ];
    }

    public function messages()
    {
        return [
            'insPhotoProduct.required'  => 'Image is not uploaded.',
            'insPhotoProduct.mimes'  => 'This image extension is not allowed .',
            'insPhotoProduct.max'  => 'Maximum size of image is 2 MB.',
            'adminProductAddName.required'  => 'Name is empty.',
            'adminProductAddName.regex'  => 'Name must have between 10 and 50 characters .',
            'adminProductAddDesc.required'  => 'Description is empty.',
            'adminProductAddDesc.regex'  => 'Description must have minimum 15 characters.',
            'adminProductAddPrice.required'  => 'Price is empty.',
            'adminProductAddPrice.regex'  => 'Price is not valid',
           // 'adminProductAddDiscount.required'  => 'Discount is empty.',
            'adminProductAddCat.not_in'  => 'Category is not selected.'
        ];
    }
}
