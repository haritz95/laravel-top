<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdStoreRequest extends FormRequest
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
            'spot' => 'required',
            'days' => 'required',
            'tittle' => 'required',
            'website' => 'required|url|min:8|max:100',
            'banner_link' => 'required_without_all:banner', 
            'banner' => 'required_without_all:banner_link|mimes:jpeg,jpg,png,gif|max:5000',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages()
    {
        return [
            'spot.required' => 'Please select a spot',
            'days.required' => 'Please select a plan',
            'tittle.required' => 'Tittle is required',
            'website' => 'required|url|min:8|max:100',
            'banner_link' => 'Please enter a valid url',
            'g-recaptcha-response.required' => 'Recaptcha is required!',
        ];
    }
}
