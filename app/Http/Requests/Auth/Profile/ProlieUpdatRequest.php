<?php

namespace App\Http\Requests\Auth\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProlieUpdatRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$this->id,
            'address'=>'required',
            'contact'=>'required|digits:10',
            'usertype_id' =>'required:not_in:0',


        ];
    }
}
