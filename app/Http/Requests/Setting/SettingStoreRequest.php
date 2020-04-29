<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
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
            'company' =>'required',
            'address'=> 'required',
            'contact'=> 'required|digits:10',
            'description'=> 'required',
            'email'=> 'required|email',
            'image'=> 'required|mimes:jpeg,png,jpg',
        ];
    }
}
