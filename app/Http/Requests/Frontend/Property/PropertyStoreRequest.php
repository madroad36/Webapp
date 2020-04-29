<?php

namespace App\Http\Requests\Frontend\Property;

use Illuminate\Foundation\Http\FormRequest;

class PropertyStoreRequest extends FormRequest
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
            'subcategory_id'=>'required|not_in:0',
            'place_id'=>'required|not_in:0',
            'title'=>'required',
            'area'=>'required',
            'price'=>'required',
            'image'=>'required',
            'owner_image'=>'required',
            'description'=>'required',
            'feature'=>'required',
            'short_description'=>'required',
            'location_id'=>'required:not_in:0',
            'category_id'=>'required',
            'name'=>'required',
            'contact'=>'required',
            'citizen'=>'required',

        ];
    }
}
