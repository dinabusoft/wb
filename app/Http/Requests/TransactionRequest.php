<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest 
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
			'date_in' => 'required|date',
			'date_out' => 'nullable|date',
			'time_in' => 'required|date',
			'time_out' => 'nullable|date',
			'weight_in' => 'required|numeric',
			'weight_out' => 'nullable|numeric',
			'ref_no' => 'nullable|max:50',
			'police_no' => 'required|max:50',
			'driver_name' => 'nullable|max:255',
			'driver_phone' => 'nullable|max:20',
			'materials_id' => 'required|exists:master_materials,id|numeric',
			'customers_id' => 'required|exists:master_customers,id|numeric',
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
