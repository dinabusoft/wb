<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\MasterCustomer;
use App\Http\Requests\MasterCustomerRequest;
use App\Http\Resources\MasterCustomerResource;


/**
 * MasterCustomer
 *
 * @Resource("MasterCustomer", uri="/master_customers")
 */

class MasterCustomerController extends ApiController
{

        //list tabel
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $query = MasterCustomer::query()->when($request->get('search'), function ($query, $search) {
                $search = strtolower(trim($search));
                return $query->whereRaw('(LOWER(name) LIKE ? or LOWER(street) LIKE ? or LOWER(district) LIKE ? or LOWER(regency) LIKE ?)', ["%$search%","%$search%","%$search%","%$search%"]);
            })->when($request->get('sort'), function ($query, $sortBy) {
                return $query->orderBy($sortBy['key'], $sortBy['order']);
            });

            $data = $query->paginate($request->get('limit', 10));

            return MasterCustomerResource::collection($data)->response()->getData(true);
        }

        return inertia('MasterCustomer/Index');
    }

      public function getOptions(Request $request)
    {
        return response()->json([
        'customers' => MasterCustomer::select('id', 'name')->get()
    ]);
    }

    //form create
    public function create()
    {
        return inertia('MasterCustomer/Create');
    }

    //form clone
    public function show(MasterCustomer $mastercustomer)
    {
      return inertia('MasterCustomer/Create', [
        'data' => $mastercustomer
      ]);
    }

    //save new data
    public function store(MasterCustomerRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $model=new MasterCustomer;
        $model->fill($data);
        if ($model->save()) {
            $message = sprintf('Successfully created %s', $model->name);
            return inertia('MasterCustomer/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
            $message = 'Error server internal occurred while saving Master Customer. Please try again later';
            return inertia('MasterCustomer/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

    //form edit
    public function edit(MasterCustomer $mastercustomer)
    {
        return inertia('MasterCustomer/Edit', [
            'data' => $mastercustomer
        ]);
    }
 
    //save update data
    public function update(MasterCustomerRequest $request,  MasterCustomer $mastercustomer)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $mastercustomer->fill($data);

        if ($mastercustomer->save()) {
            $message = sprintf('Successfully updated %s', $mastercustomer->name);
            return inertia('MasterCustomer/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
             $message = 'Error server internal occurred while saving Master Customers. Please try again later';
             return inertia('MasterCustomer/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

    //delete data
    public function destroy(Request $request, $mastercustomer)
    {
        $mastercustomer = MasterCustomer::findOrFail($mastercustomer);
        if ($mastercustomer->delete()) {
            $mastercustomer ['deleted_by'] = $request->user()->id;
            $mastercustomer->save();
            $message = sprintf('Successfully deleted %s', $mastercustomer->name);
            return response()->json([
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
              $message = 'Error server internal occurred while deleting Master Customer. Please try again later';
              return response()->json([
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }


}
