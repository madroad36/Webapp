<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementStoreRequest extends FormRequest
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
             'name' =>'required',
             'contact' => 'required|digits:10',
             'index' => 'required|unique:advertisements',
             'image' => 'required|image|mimes:jpg,gif,png,jpeg',
        ];
    }
}
