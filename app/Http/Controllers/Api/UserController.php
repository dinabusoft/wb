<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Transformers\UserTransformer;


/**
 * User
 *
 * @Resource("User", uri="/users")
 */

class UserController extends ApiController
{
    
    public function index(Request $request)
    {
       return $this->response->paginator(User::paginate(10), new UserTransformer());
    }

    public function show(Request $request, User $user)
    {
      return $this->response->item($user, new UserTransformer());
    }

    public function store(Request $request)
    {
        $model=new User;
        $model->fill($request->all());
        if ($model->save()) {
            return $this->response->item($model, new UserTransformer());
        } else {
              return $this->response->errorInternal('Error occurred while saving User');
        }
    }
 
    public function update(Request $request,  User $user)
    {
        $user->fill($request->all());

        if ($user->save()) {
            return $this->response->item($user, new UserTransformer());
        } else {
             return $this->response->errorInternal('Error occurred while saving User');
        }
    }

    public function destroy(Request $request, $user)
    {
        $user = User::findOrFail($user);

        if ($user->delete()) {
            return $this->response->array(['status' => 200, 'message' => 'User successfully deleted']);
        } else {
             return $this->response->errorInternal('Error occurred while deleting User');
        }
    }

}
