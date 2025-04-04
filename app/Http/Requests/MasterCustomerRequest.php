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
			'name' => 'required|max:255',
			'street' => 'required|max:255',
			'district' => 'required|max:255',
			'regency' => 'required|max:255',
			'province' => 'required|max:255',
			'postalcode' => 'nullable|max:255',
			'telephone' => 'required|max:20',
			'phone' => 'nullable|max:20',
			'status' => 'required',
			'remark' => 'nullable|string',
		
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
