<?php

namespace App\Http\Requests\ServiceSubCategory;

use Illuminate\Foundation\Http\FormRequest;

class ServiceSubCategoryStoreRequest extends FormRequest
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
            'title'=>'required|unique:service_subcategory,title,Null,id,category_id,'.$this->category_id,
            'category_id'=>'required|not_in:0',

        ];
    }
}
