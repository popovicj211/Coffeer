<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderAddRequest extends FormRequest
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
            'insPhotoSlide' => 'required|file|mimes:jpg,jpeg,png|max:2000',
             'adminSlideAddName' => 'required|regex:/^[A-Z][\w\s]{3,50}$/',
               'adminSlideAddDesc' =>  'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'insPhotoSlide.required'  => 'Image is not uploaded.',
            'insPhotoSlide.mimes'  => 'This image extension is not allowed .',
            'insPhotoSlide.max'  => 'Maximum size of image is 2 MB.',
            'adminSlideAddName.required'  => 'Name is empty.',
            'adminSlideAddName.regex'  => 'Name is not valid ',
            'adminSlideAddDesc.required'  => 'Text is empty.',
            'adminSlideAddDesc.regex'  => 'Text must have minimum 10 characters.'
        ];
    }
}
