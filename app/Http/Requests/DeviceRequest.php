<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest 
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
			'name' => 'nullable|max:50',
			'port' => 'nullable|numeric',
			'baudrate' => 'nullable|max:50',
			'databits' => 'nullable|max:50',
			'stopbits' => 'nullable|max:50',
			'parity' => 'nullable|max:50',
			'inputlen' => 'nullable|numeric',
			'threshold' => 'nullable|max:50',
			'delimiter' => 'nullable|max:50',
			'index' => 'nullable|numeric',
			'status' => 'nullable',
			'remark' => 'nullable|string',
			'log' => 'nullable|string',
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
