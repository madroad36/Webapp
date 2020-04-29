<?php

namespace App\Http\Requests\Advertisement;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class AdvertisementUpdateRequest extends FormRequest
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
           'index' => 'required|unique:advertisements,index,'.$this->id,
           // 'image' => 'required|image,id|mimes:jpg,gif,png,jpeg'.$this->id,
       ];
   }
}
