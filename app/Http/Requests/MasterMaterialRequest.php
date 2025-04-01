<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterMaterialRequest extends FormRequest 
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
			'code' => 'nullable|max:50',
			'name' => 'nullable|max:255',
			'pack' => 'nullable|max:50',
			'content' => 'nullable|max:50',
			'remark' => 'nullable|string',
			'status' => 'nullable',
			'created_by' => 'nullable|numeric',
			'updated_by' => 'nullable|numeric',
			'deleted_by' => 'nullable|numeric',
        ];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
     
        ];
    }

}
