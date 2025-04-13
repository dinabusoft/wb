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
          if ($this->route()->getName() === 'transactions.out') {
            return [
            
            'date' => 'required',
            'time' => 'required',
            'weight' => 'required',
                
            'date_out' => 'required',
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
        }else{
         return [
            
            'date' => 'required',
            'time' => 'required',
            'weight' => 'required',
            
            'date_in' => 'required',
            'time_in' => 'required',
            'weight_in' => 'required',


            'ref_no' => 'nullable',
            'police_no' => 'required',
            'driver_name' => 'nullable',
            'driver_phone' => 'nullable',
            'materials_id' => 'required',
            'customers_id' => 'required',
            'remark' => 'nullable'
        ];
        }
    }

    public function prepareForValidation()
    {
            if ($this->route()->getName() === 'transactions.out') { 
            $this->merge([
                'date_out' => $this->date,
                'time_out' => $this->time,
                'weight_out' => $this->weight
            ]);
            }else{ 
            $this->merge([
                'date_in' => $this->date,
                'time_in' => $this->time,
                'weight_in' => $this->weight
            ]);

            }   
    //$this->replace($this->except(['date', 'time', 'weight']));
    $this->request->remove('date');
    $this->request->remove('time');
    $this->request->remove('weight');
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
             'police_no.required' => 'Nomor polisi wajib diisi',
        'materials_id.required' => 'Material wajib dipilih',
        'customers_id.required' => 'Customer wajib dipilih',
        'numeric' => 'Kolom :attribute harus berupa angka',
        'date' => 'Format tanggal tidak valid',
        ];
    }

}
