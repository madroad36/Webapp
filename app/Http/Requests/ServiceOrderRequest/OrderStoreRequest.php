<?php

namespace App\Http\Requests\ServiceOrderRequest;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'location'=>'required',
            'description'=>'required',
            'contact'=>'required|digits:10',
            'pereffered_date'=>'required'
        ];
    }
}
