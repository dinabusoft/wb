<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterCustomerRequest extends FormRequest 
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
			'name' => 'nullable|max:255',
			'street' => 'nullable|max:255',
			'district' => 'nullable|max:255',
			'regency' => 'nullable|max:255',
			'province' => 'nullable|max:255',
			'postalcode' => 'nullable|max:255',
			'telephone' => 'nullable|max:20',
			'phone' => 'nullable|max:20',
			'status' => 'nullable',
			'remark' => 'nullable|string',
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
