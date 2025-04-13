<?php

namespace App\Policies;

use \App\Models\Device;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
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
     * Determine whether the user can view the Device.
     *
     * @param  User  $user
     * @param  Device  $device
     * @return mixed
     */
    public function view(User $user, Device  $device)
    {
        return true;
    }
    /**
     * Determine whether the user can create Device.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can update the Device.
     *
     * @param User $user
     * @param  Device  $device
     * @return mixed
     */
    public function update(User $user, Device  $device)
    {
        return true;
    }
    /**
     * Determine whether the user can delete the Device.
     *
     * @param User  $user
     * @param  Device  $device
     * @return mixed
     */
    public function delete(User $user, Device  $device)
    {
        return true;
    }

}
