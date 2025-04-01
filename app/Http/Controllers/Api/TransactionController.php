<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;
use App\Transformers\TransactionTransformer;
use App\Models\MasterMaterial;
use App\Models\MasterCustomer;


/**
 * Transaction
 *
 * @Resource("Transaction", uri="/transactions")
 */

class TransactionController extends ApiController
{
    
    public function index(Request $request)
    {
       return $this->response->paginator(Transaction::paginate(10), new TransactionTransformer());
    }

    public function show(Request $request, Transaction $transaction)
    {
      return $this->response->item($transaction, new TransactionTransformer());
    }

    public function store(Request $request)
    {
        $model=new Transaction;
        $model->fill($request->all());
        if ($model->save()) {
            return $this->response->item($model, new TransactionTransformer());
        } else {
              return $this->response->errorInternal('Error occurred while saving Transaction');
        }
    }
 
    public function update(Request $request,  Transaction $transaction)
    {
        $transaction->fill($request->all());

        if ($transaction->save()) {
            return $this->response->item($transaction, new TransactionTransformer());
        } else {
             return $this->response->errorInternal('Error occurred while saving Transaction');
        }
    }

    public function destroy(Request $request, $transaction)
    {
        $transaction = Transaction::findOrFail($transaction);

        if ($transaction->delete()) {
            return $this->response->array(['status' => 200, 'message' => 'Transaction successfully deleted']);
        } else {
             return $this->response->errorInternal('Error occurred while deleting Transaction');
        }
    }

}
