<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\MasterMaterial;
use App\Http\Requests\MasterMaterialRequest;
use App\Http\Resources\MasterMaterialResource;

/**
 * MasterMaterial
 *
 * @Resource("MasterMaterial", uri="/master_materials")
 */

class MasterMaterialController extends ApiController
{
    //list tabel
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $query = MasterMaterial::query()->when($request->get('search'), function ($query, $search) {
                $search = strtolower(trim($search));
                return $query->whereRaw('LOWER(code) LIKE ? or LOWER(name) LIKE ? or LOWER(pack) LIKE ? or LOWER(content) LIKE ? or LOWER(remark) LIKE ?', ["%$search%","%$search%","%$search%","%$search%","%$search%"]);
            })->when($request->get('sort'), function ($query, $sortBy) {
                return $query->orderBy($sortBy['key'], $sortBy['order']);
            });

            $data = $query->paginate($request->get('limit', 10));

            return MasterMaterialResource::collection($data)->response()->getData(true);
        }

        return inertia('MasterMaterial/Index');
    }

    //form create
    public function create()
    {
        return inertia('MasterMaterial/Create');
    }

    //form clone
    public function show(MasterMaterial $mastermaterial)
    {
      return inertia('MasterMaterial/Create', [
        'data' => $mastermaterial
      ]);
    }

    //save new data
    public function store(MasterMaterialRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $model=new MasterMaterial;
        $model->fill($data);
        if ($model->save()) {
            $message = sprintf('Successfully created %s', $model->name);
            return inertia('MasterMaterial/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
            $message = 'Error server internal occurred while saving Master Material. Please try again later';
            return inertia('MasterMaterial/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

    //form edit
    public function edit(MasterMaterial $mastermaterial)
    {
        return inertia('MasterMaterial/Edit', [
            'data' => $mastermaterial
        ]);
    }
 
    //save update data
    public function update(MasterMaterialRequest $request,  MasterMaterial $mastermaterial)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        $mastermaterial->fill($data);

        if ($mastermaterial->save()) {
            $message = sprintf('Successfully updated %s', $mastermaterial->name);
            return inertia('MasterMaterial/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
             $message = 'Error server internal occurred while saving MasterMaterial. Please try again later';
             return inertia('MasterMaterial/Index', [
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

    //delete data
    public function destroy(Request $request, $mastermaterial)
    {
        $mastermaterial = MasterMaterial::findOrFail($mastermaterial);
        if ($mastermaterial->delete()) {
            $mastermaterial ['deleted_by'] = $request->user()->id;
            $mastermaterial->save();
            $message = sprintf('Successfully deleted %s', $mastermaterial->name);
            return response()->json([
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'info'
                ]
            ]);
        } else {
              $message = 'Error server internal occurred while deleting Master Material. Please try again later';
              return response()->json([
                'message' => ['show' => true, 
                             'message' => $message,
                             'color' => 'error'
                ]
            ]);
        }
    }

}
