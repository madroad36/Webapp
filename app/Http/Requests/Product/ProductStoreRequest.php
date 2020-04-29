<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'title'=>'required|unique:product,title,Null,id,category_id,'.$this->category_id,
            'image'=>'required|mimes:jpeg,png,jpg',
            'description' =>'required',
            'price'=>'required',
            'category_id'=>'required|not_in:0'
        ];
    }
}
