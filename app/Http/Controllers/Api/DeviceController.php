<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Device;
use App\Http\Requests\DeviceRequest;
use App\Http\Resources\DeviceResource;


/**
 * Device
 *
 * @Resource("Device", uri="/devices")
 */

class DeviceController extends ApiController
{
    
     //list tabel
     public function index(Request $request)
     {
         if ($request->wantsJson()) {
             $query = Device::query()->when($request->get('search'), function ($query, $search) {
                 $search = strtolower(trim($search));
                 return $query->whereRaw('(LOWER(code) LIKE ? or LOWER(name) LIKE ? or LOWER(pack) LIKE ? or LOWER(content) LIKE ? or LOWER(remark) LIKE ?)', ["%$search%","%$search%","%$search%","%$search%","%$search%"]);
             })->when($request->get('sort'), function ($query, $sortBy) {
                 return $query->orderBy($sortBy['key'], $sortBy['order']);
             });
 
             $data = $query->paginate($request->get('limit', 10));
 
             return DeviceResource::collection($data)->response()->getData(true);
         }
 
         return inertia('Device/Index');
     }
 
     //form create
     public function create()
     {
         return inertia('Device/Create');
     }
 
     //form clone
     public function show(Device $device)
     {
       return inertia('Device/Create', [
         'data' => $device
       ]);
     }
 
     //save new data
     public function store(DeviceRequest $request)
     {
         $data = $request->validated();
         $data['created_by'] = $request->user()->id;
         $model=new Device;
         $model->fill($data);
         if ($model->save()) {
             $message = sprintf('Successfully created %s', $model->name);
             return inertia('Device/Index', [
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'info'
                 ]
             ]);
         } else {
             $message = 'Error server internal occurred while saving Device. Please try again later';
             return inertia('Device/Index', [
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'error'
                 ]
             ]);
         }
     }
 
     //form edit
     public function edit(Device $device)
     {
         return inertia('Device/Edit', [
             'data' => $device
         ]);
     }
  
     //save update data
     public function update(DeviceRequest $request,  Device $device)
     {
         $data = $request->validated();
         $data['updated_by'] = $request->user()->id;
         $device->fill($data);
 
         if ($device->save()) {
             $message = sprintf('Successfully updated %s', $device->name);
             return inertia('Device/Index', [
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'info'
                 ]
             ]);
         } else {
              $message = 'Error server internal occurred while saving Devices. Please try again later';
              return inertia('Device/Index', [
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'error'
                 ]
             ]);
         }
     }
 
     //delete data
     public function destroy(Request $request, $device)
     {
         $device = Device::findOrFail($device);
         if ($device->delete()) {
             $device ['deleted_by'] = $request->user()->id;
             $device->save();
             $message = sprintf('Successfully deleted %s', $device->name);
             return response()->json([
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'info'
                 ]
             ]);
         } else {
               $message = 'Error server internal occurred while deleting Device. Please try again later';
               return response()->json([
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'error'
                 ]
             ]);
         }
     }

     //list tabel
     public function indexMydevice(Request $request)
     {
        $user_id = $request->user()->id;
        $data = Device::whereRaw('status LIKE ? and (user_id is null or user_id LIKE ?)', ["1","%$user_id%"])
         ->orderBy('user_id', "desc")
         ->get();
 
        return DeviceResource::collection($data)->response()->getData(true);
     }

     public function saveMyDevice(DeviceRequest $request,  Device $device)
     {
         $data = $request->validated();
         $data['status'] = 1;
         $data['updated_by'] = $request->user()->id;
         if($device->user_id>0 && !empty($device)){
            $data['updated_by'] = $request->user()->id;
            $device->fill($data);
         }else{
            $data['created_by'] = $request->user()->id;
            $data['user_id'] = $request->user()->id;
            $device=new Device;
            $device->fill($data);
         }
         if ($device->save()) {
             $message = sprintf('Successfully save %s', $device->name);
             return response()->json([
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'info'
             ],
             'data' => $device
             ]);
         } else {
              $message = 'Error server internal occurred while saving Devices. Please try again later';
              return response()->json([
                 'message' => ['show' => true, 
                              'message' => $message,
                              'color' => 'error'
              ],
              'data' => $device
             ]);
         }
     }

}
