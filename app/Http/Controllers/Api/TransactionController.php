<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\TransactionRequest1;
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
        $query = Transaction::query()
            ->with(['material', 'customer', 'created_actor', 'updated_actor'])
            ->when($request->get('search'), function ($query, $search) {
                $search = strtolower(trim($search));
                return $query->whereRaw('LOWER(police_no) LIKE ? or LOWER(ref_no) LIKE ?', ["%$search%","%$search%"]);
            });

        if ($request->wantsJson()) {
            $data = $query->paginate($request->get('limit', 10));
            return TransactionResource::collection($data);
        }

        return inertia('Transaction/Index', [
            'transactions' => $query->paginate(10)
        ]);
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
       \Log::info('Request Data:', $request->all());
         $data = $request->validated(); 
        $data['created_by'] = auth()->id();
        $Transaction = Transaction::create($data);
    
    return redirect()->back()->with([
        'message' => [
            'show' => true,
            'text' => 'Data berhasil disimpan',
            'color' => 'success'
        ]
    ]);
    }

    public function saveOut(Request $request, $id)
    {
         \Log::info('Starting saveOut for transaction:', ['id' => $id]);
          \Log::info('Request data:', $request->all());

        $transaction = Transaction::findOrFail($id);
          
        \Log::info('Found transaction:', $transaction->toArray());

        $data = $request->validate([
            'weight_out' => 'required|numeric',
            'date_out' => 'required|date',
            'time_out' => 'required',
        ]);
           \Log::info('Validated data:', $data);

        $data['updated_by'] = auth()->id();

        
        $transaction->update($data);
        
         \Log::info('Transaction updated successfully:', $transaction->fresh()->toArray());
        
        return response()->json([
            'success' => true,
            'message' => 'Save out berhasil disimpan',
            'data' => $transaction->fresh()
        ]);
    }
    //form edit
    public function edit(Transaction $transaction)
    {
        return inertia('Transaction/Edit', [
            'data' => [
            'id' => $transaction->id,
            'date_in' => $transaction->date_in,
            'date_out' => $transaction->date_out,
            'time_in' => $transaction->time_in,
            'time_out' => $transaction->time_out,
            'weight_in' => $transaction->weight_in,
            'weight_out' => $transaction->weight_out,
            'ref_no' => $transaction->ref_no,
            'police_no' => $transaction->police_no,
            'driver_name' => $transaction->driver_name,
            'driver_phone' => $transaction->driver_phone,
            'materials_id' => $transaction->materials_id,
            'customers_id' => $transaction->customers_id,
            'remark' => $transaction->remark,
            // Jika perlu relasi
            'material' => $transaction->material,
            'customer' => $transaction->customer
        ]
        ]);
    }
 
    //save update data
   public function update(TransactionRequest1 $request, Transaction $transaction)
        {
              $data = $request->only([
            'date_in', 'time_in', 'weight_in',
            'date_out', 'time_out', 'weight_out',
            'ref_no', 'police_no', 'driver_name',
            'driver_phone', 'materials_id', 'customers_id', 'remark'
        ]);
        
        $data['updated_by'] = auth()->id();

        try {
            $transaction->fill($data)->save();
            
            return redirect()->route('home')->with([
                'message' => [
                    'show' => true,
                    'text' => 'Data berhasil diupdate',
                    'color' => 'success'
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with([
                'message' => [
                    'show' => true,
                    'text' => 'Gagal menyimpan data: ' . $e->getMessage(),
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

     //get single data
     public function showOut(Transaction $transaction)
     {
        return response()->json([
         'data' => $transaction
       ]);
     }

}
