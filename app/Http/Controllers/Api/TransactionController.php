<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\MasterCustomer;


/**
 * Transaction
 *
 * @Resource("Transaction", uri="/transactions")
 */

class TransactionController extends ApiController
{
    
    //list tabel
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $query = Transaction::query()->when($request->get('search'), function ($query, $search) {
                $search = strtolower(trim($search));
                return $query->whereRaw('(LOWER(code) LIKE ? or LOWER(name) LIKE ? or LOWER(pack) LIKE ? or LOWER(content) LIKE ? or LOWER(remark) LIKE ?)', ["%$search%","%$search%","%$search%","%$search%","%$search%"]);
            })->when($request->get('sort'), function ($query, $sortBy) {
                return $query->orderBy($sortBy['key'], $sortBy['order']);
            });

            $data = $query->paginate($request->get('limit', 10));

            return TransactionResource::collection($data)->response()->getData(true);
        }

        return inertia('Transaction/Index');
    }

    //form create
    public function create()
    {
        return inertia('Transaction/Create');
    }

    //form clone
    public function show(Transaction $transaction)
    {
      return inertia('Transaction/Create', [
        'data' => $transaction
      ]);
    }

    //save new data
    public function store(TransactionRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $model=new Transaction;
        $model->fill($data);
        if ($model->save()) {
            $message = sprintf('Successfully created %s', $model->name);
            return inertia('Transaction/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
            $message = 'Error server internal occurred while saving Transaction. Please try again later';
            return inertia('Transaction/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

    //form edit
    public function edit(Transaction $transaction)
    {
        return inertia('Transaction/Edit', [
            'data' => $transaction
        ]);
    }
 
    //save update data
    public function update(TransactionRequest $request,  Transaction $transaction)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $transaction->fill($data);

        if ($transaction->save()) {
            $message = sprintf('Successfully updated %s', $transaction->name);
            return inertia('Transaction/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
             $message = 'Error server internal occurred while saving Transaction. Please try again later';
             return inertia('Transaction/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

    //delete data
    public function destroy(Request $request, $transaction)
    {
        $transaction = Transaction::findOrFail($transaction);
        if ($transaction->delete()) {
            $transaction ['deleted_by'] = $request->user()->id;
            $transaction->save();
            $message = sprintf('Successfully deleted %s', $transaction->name);
            return response()->json([
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
              $message = 'Error server internal occurred while deleting Transaction. Please try again later';
              return response()->json([
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

}
