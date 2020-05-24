<?php

namespace App\Http\Requests;

class AllIndexRequest extends BaseFormRequest
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
            'offset' => 'numeric|integer|min:1|max:20',
            'sortBy' => 'in:id,name,slug,price,description,created_at',
            'sort' => 'in:asc,desc'
        ];
    }
}
