<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\UsersRole;
use App\Transformers\UsersRoleTransformer;


/**
 * UsersRole
 *
 * @Resource("UsersRole", uri="/users_roles")
 */

class UsersRoleController extends ApiController
{
    
    public function index(Request $request)
    {
       return $this->response->paginator(UsersRole::paginate(10), new UsersRoleTransformer());
    }

    public function show(Request $request, UsersRole $usersrole)
    {
      return $this->response->item($usersrole, new UsersRoleTransformer());
    }

    public function store(Request $request)
    {
        $model=new UsersRole;
        $model->fill($request->all());
        if ($model->save()) {
            return $this->response->item($model, new UsersRoleTransformer());
        } else {
              return $this->response->errorInternal('Error occurred while saving UsersRole');
        }
    }
 
    public function update(Request $request,  UsersRole $usersrole)
    {
        $usersrole->fill($request->all());

        if ($usersrole->save()) {
            return $this->response->item($usersrole, new UsersRoleTransformer());
        } else {
             return $this->response->errorInternal('Error occurred while saving UsersRole');
        }
    }

    public function destroy(Request $request, $usersrole)
    {
        $usersrole = UsersRole::findOrFail($usersrole);

        if ($usersrole->delete()) {
            return $this->response->array(['status' => 200, 'message' => 'UsersRole successfully deleted']);
        } else {
             return $this->response->errorInternal('Error occurred while deleting UsersRole');
        }
    }

}
