<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandStoreRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:brands,name,',
            'category_id' => 'required|integer',
        ];

        switch($this->method()){
            case "PUT":
            case "PATCH":
                $rules['name'] = 'required|unique:brands,name,' .$this->brand->id;
        }

        return $rules;
    }

    public function messages(){
        return[
            'category_id.required' => 'Category name is required',
            'category_id.integer' => 'Plz select category for options',
        ];
    }
}
