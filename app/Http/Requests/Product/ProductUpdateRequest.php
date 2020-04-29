<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'title'=>'required|unique:product,title,'.$this->id .',id,category_id,'.$this->category_id,
            'image'=>'nullable',
            'description' =>'required',
            'price'=>'required',
            'category_id'=>'required|not_in:0'
        ];
    }
}
