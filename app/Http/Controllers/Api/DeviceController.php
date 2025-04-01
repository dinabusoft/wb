<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Device;
use App\Transformers\DeviceTransformer;


/**
 * Device
 *
 * @Resource("Device", uri="/devices")
 */

class DeviceController extends ApiController
{
    
    public function index(Request $request)
    {
       return $this->response->paginator(Device::paginate(10), new DeviceTransformer());
    }

    public function show(Request $request, Device $device)
    {
      return $this->response->item($device, new DeviceTransformer());
    }

    public function store(Request $request)
    {
        $model=new Device;
        $model->fill($request->all());
        if ($model->save()) {
            return $this->response->item($model, new DeviceTransformer());
        } else {
              return $this->response->errorInternal('Error occurred while saving Device');
        }
    }
 
    public function update(Request $request,  Device $device)
    {
        $device->fill($request->all());

        if ($device->save()) {
            return $this->response->item($device, new DeviceTransformer());
        } else {
             return $this->response->errorInternal('Error occurred while saving Device');
        }
    }

    public function destroy(Request $request, $device)
    {
        $device = Device::findOrFail($device);

        if ($device->delete()) {
            return $this->response->array(['status' => 200, 'message' => 'Device successfully deleted']);
        } else {
             return $this->response->errorInternal('Error occurred while deleting Device');
        }
    }

}
