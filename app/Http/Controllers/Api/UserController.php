<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use App\Models\UsersRole;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


/**
 * User
 *
 * @Resource("User", uri="/users")
 */

class UserController extends ApiController
{
    
   //list tabel
   public function index(Request $request)
   {
       if ($request->wantsJson()) {
           $query = User::query()->when($request->get('search'), function ($query, $search) {
               $search = strtolower(trim($search));
               return $query->whereRaw('(LOWER(code) LIKE ? or LOWER(name) LIKE ? or LOWER(pack) LIKE ? or LOWER(content) LIKE ? or LOWER(remark) LIKE ?)', ["%$search%","%$search%","%$search%","%$search%","%$search%"]);
           })->when($request->get('sort'), function ($query, $sortBy) {
               return $query->orderBy($sortBy['key'], $sortBy['order']);
           });

           $data = $query->paginate($request->get('limit', 10));

           return UserResource::collection($data)->response()->getData(true);
       }

       return inertia('User/Index');
   }

   //form create
   public function create()
   {
       return inertia('User/Create');
   }


   //save new data
   public function store(Request $request)
   {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       if ($user->id) {
            $role = UsersRole::create([
                'roles' => $request->role,
                'user_id' => $user->id,
            ]);
           $message = sprintf('Successfully created %s', $user->name);
           return inertia('User/Index', [
               'message' => ['show' => true, 
                            'message' => $message,
                            'color' => 'info'
               ]
           ]);
       } else {
           $message = 'Error server internal occurred while saving User. Please try again later';
           return inertia('User/Index', [
               'message' => ['show' => true, 
                            'message' => $message,
                            'color' => 'error'
               ]
           ]);
       }
   }

    //form clone
    public function show(User $user)
    {
        $user['role'] = $user->roles?->roles;
        return inertia('User/Edit', [
            'data' => $user,
        ]);
    }

   //form edit
   public function edit(User $user)
   {
       $user['role'] = $user->roles?->roles;
       return inertia('User/Edit', [
           'data' => $user,
       ]);
   }

   //save update data
   public function update(Request $request,  User $user)
   {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|string'
        ]);

        $request->password = Hash::make($request->password);

       $user->fill([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
       ]);
    
       if ($user->save()) {
            $role = UsersRole::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'roles' => $request->role,
            ]);
           $message = sprintf('Successfully updated %s', $user->name);
           return inertia('User/Index', [
               'message' => ['show' => true, 
                            'message' => $message,
                            'color' => 'info'
               ]
           ]);
       } else {
            $message = 'Error server internal occurred while saving User. Please try again later';
            return inertia('User/Index', [
               'message' => ['show' => true, 
                            'message' => $message,
                            'color' => 'error'
               ]
           ]);
       }
   }

   //delete data
   public function destroy(Request $request, $user)
   {
       $user = User::findOrFail($user);
       if ($user->delete()) {
           $message = sprintf('Successfully deleted %s', $user->name);
           return response()->json([
               'message' => ['show' => true, 
                            'message' => $message,
                            'color' => 'info'
               ]
           ]);
       } else {
             $message = 'Error server internal occurred while deleting User. Please try again later';
             return response()->json([
               'message' => ['show' => true, 
                            'message' => $message,
                            'color' => 'error'
               ]
           ]);
       }
   }

}
