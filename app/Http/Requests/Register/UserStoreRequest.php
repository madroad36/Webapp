<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'email'=>'required|unique:users,email',
            'contact' =>'required|digits:10',
            'address'=>'required',
            'usertype_id' =>'required:not_in:0',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
        ];
    }
}
