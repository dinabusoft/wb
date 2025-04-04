<?php

namespace App\Policies;

use \App\Models\MasterMaterial;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterMaterialPolicy
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
     * Determine whether the user can view the MasterMaterial.
     *
     * @param  User  $user
     * @param  MasterMaterial  $masterMaterial
     * @return mixed
     */
    public function view(User $user, MasterMaterial  $masterMaterial)
    {
        return true;
    }
    /**
     * Determine whether the user can create MasterMaterial.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can update the MasterMaterial.
     *
     * @param User $user
     * @param  MasterMaterial  $masterMaterial
     * @return mixed
     */
    public function update(User $user, MasterMaterial  $masterMaterial)
    {
        return true;
    }
    /**
     * Determine whether the user can delete the MasterMaterial.
     *
     * @param User  $user
     * @param  MasterMaterial  $masterMaterial
     * @return mixed
     */
    public function delete(User $user, MasterMaterial  $masterMaterial)
    {
        return true;
    }

}
