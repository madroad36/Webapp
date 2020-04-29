<?php

namespace App\Http\Requests\UserType;

use Illuminate\Foundation\Http\FormRequest;

class UserTypeUpdateRequest extends FormRequest
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
            'name' =>'required|unique:usertype,name,'.$this->id
        ];
    }
}
