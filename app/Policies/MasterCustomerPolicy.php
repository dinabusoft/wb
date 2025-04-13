<?php

namespace App\Policies;

use \App\Models\MasterCustomer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterCustomerPolicy
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
     * Determine whether the user can view the MasterCustomer.
     *
     * @param  User  $user
     * @param  MasterCustomer  $masterCustomer
     * @return mixed
     */
    public function view(User $user, MasterCustomer  $masterCustomer)
    {
        return true;
    }
    /**
     * Determine whether the user can create MasterCustomer.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can update the MasterCustomer.
     *
     * @param User $user
     * @param  MasterCustomer  $masterCustomer
     * @return mixed
     */
    public function update(User $user, MasterCustomer  $masterCustomer)
    {
        return true;
    }
    /**
     * Determine whether the user can delete the MasterCustomer.
     *
     * @param User  $user
     * @param  MasterCustomer  $masterCustomer
     * @return mixed
     */
    public function delete(User $user, MasterCustomer  $masterCustomer)
    {
        return true;
    }

}
