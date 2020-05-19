<?php

namespace App\Http\Requests;

class ProductStoreRequest extends BaseFormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ];
    }

    /*
    public function messages()
    {
        //custom validation messages
        return [
          'name.required' => 'The name field is required.',
          'name.string' => 'The name field must be string.',
          'name.max' => 'The name may not be greater than 255 characters.',
          'price.required' => 'The price field is required.',
            //...
        ];
    }
    */
}
