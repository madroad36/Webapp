<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class PlaceStoreRequest extends FormRequest
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
            'name'=>'required|unique:place,name,Null,id,location_id,'.$this->location_id,
            'location_id'=>'required|not_in:0'
        ];
    }
}
