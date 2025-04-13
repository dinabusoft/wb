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
     public function rules(): array
    {
          return [
            'date_in' => 'required',
            'time_in' => 'required',
            'weight_in' => 'required',
            'date_out' => 'nullable',
            'time_out' => 'nullable',
            'weight_out' => 'nullable',
            'ref_no' => 'nullable',
            'police_no' => 'required',
            'driver_name' => 'nullable',
            'driver_phone' => 'nullable',
            'materials_id' => 'required',
            'customers_id' => 'required',
            'remark' => 'nullable'
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
