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
			'code' => 'required|max:50',
			'name' => 'required|max:255',
			'pack' => 'nullable|max:50',
			'content' => 'required|max:50',
			'remark' => 'nullable|string',
			'status' => 'required',
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
