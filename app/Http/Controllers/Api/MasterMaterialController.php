<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\MasterMaterial;
use App\Transformers\MasterMaterialTransformer;


/**
 * MasterMaterial
 *
 * @Resource("MasterMaterial", uri="/master_materials")
 */

class MasterMaterialController extends ApiController
{
    
    public function index(Request $request)
    {
       return $this->response->paginator(MasterMaterial::paginate(10), new MasterMaterialTransformer());
    }

    public function show(Request $request, MasterMaterial $mastermaterial)
    {
      return $this->response->item($mastermaterial, new MasterMaterialTransformer());
    }

    public function store(Request $request)
    {
        $model=new MasterMaterial;
        $model->fill($request->all());
        if ($model->save()) {
            return $this->response->item($model, new MasterMaterialTransformer());
        } else {
              return $this->response->errorInternal('Error occurred while saving MasterMaterial');
        }
    }
 
    public function update(Request $request,  MasterMaterial $mastermaterial)
    {
        $mastermaterial->fill($request->all());

        if ($mastermaterial->save()) {
            return $this->response->item($mastermaterial, new MasterMaterialTransformer());
        } else {
             return $this->response->errorInternal('Error occurred while saving MasterMaterial');
        }
    }

    public function destroy(Request $request, $mastermaterial)
    {
        $mastermaterial = MasterMaterial::findOrFail($mastermaterial);

        if ($mastermaterial->delete()) {
            return $this->response->array(['status' => 200, 'message' => 'MasterMaterial successfully deleted']);
        } else {
             return $this->response->errorInternal('Error occurred while deleting MasterMaterial');
        }
    }

}
