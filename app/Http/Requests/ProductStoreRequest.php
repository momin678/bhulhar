<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|unique:products,name,',
            'category_id' => 'required',
            'unit_id' => 'required',
        ];
        switch($this->method()){
            case "PUT":
            case "PATCH":
                $rules['name'] = 'required|unique:products,name,'. $this->product->id;
        }

        return $rules;
    }

    public function messages()
    {
        return[
            'category_id.required' => 'Category name is required',
            'unit_id.required' => 'Unit is required',
        ];
    }
}
