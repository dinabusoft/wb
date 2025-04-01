<?php

namespace App\Policies;

use \App\Models\UsersRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersRolePolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function before(User $user)
    {
        //return true if user has super power
    }

        /**
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can view the UsersRole.
     *
     * @param  User  $user
     * @param  UsersRole  $usersRole
     * @return mixed
     */
    public function view(User $user, UsersRole  $usersRole)
    {
        return true;
    }
    /**
     * Determine whether the user can create UsersRole.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can update the UsersRole.
     *
     * @param User $user
     * @param  UsersRole  $usersRole
     * @return mixed
     */
    public function update(User $user, UsersRole  $usersRole)
    {
        return true;
    }
    /**
     * Determine whether the user can delete the UsersRole.
     *
     * @param User  $user
     * @param  UsersRole  $usersRole
     * @return mixed
     */
    public function delete(User $user, UsersRole  $usersRole)
    {
        return true;
    }

}
