<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\MasterCustomer;
use App\Transformers\MasterCustomerTransformer;


/**
 * MasterCustomer
 *
 * @Resource("MasterCustomer", uri="/master_customers")
 */

class MasterCustomerController extends ApiController
{
    
    public function index(Request $request)
    {
       return $this->response->paginator(MasterCustomer::paginate(10), new MasterCustomerTransformer());
    }

    public function show(Request $request, MasterCustomer $mastercustomer)
    {
      return $this->response->item($mastercustomer, new MasterCustomerTransformer());
    }

    public function store(Request $request)
    {
        $model=new MasterCustomer;
        $model->fill($request->all());
        if ($model->save()) {
            return $this->response->item($model, new MasterCustomerTransformer());
        } else {
              return $this->response->errorInternal('Error occurred while saving MasterCustomer');
        }
    }
 
    public function update(Request $request,  MasterCustomer $mastercustomer)
    {
        $mastercustomer->fill($request->all());

        if ($mastercustomer->save()) {
            return $this->response->item($mastercustomer, new MasterCustomerTransformer());
        } else {
             return $this->response->errorInternal('Error occurred while saving MasterCustomer');
        }
    }

    public function destroy(Request $request, $mastercustomer)
    {
        $mastercustomer = MasterCustomer::findOrFail($mastercustomer);

        if ($mastercustomer->delete()) {
            return $this->response->array(['status' => 200, 'message' => 'MasterCustomer successfully deleted']);
        } else {
             return $this->response->errorInternal('Error occurred while deleting MasterCustomer');
        }
    }

}
