<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
            'title'=>'required|unique:services,title,'.$this->id,
            'image'=>'nullable',
            'description' =>'required',
             'category_id'=>'required|not_in:0',
            'rate'=>'required',
            'rate_type'=>'required|not_in:0',
        ];
    }
}
