<?php

namespace App\Policies;

use \App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
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
     * Determine whether the user can view the Transaction.
     *
     * @param  User  $user
     * @param  Transaction  $transaction
     * @return mixed
     */
    public function view(User $user, Transaction  $transaction)
    {
        return true;
    }
    /**
     * Determine whether the user can create Transaction.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }
    /**
     * Determine whether the user can update the Transaction.
     *
     * @param User $user
     * @param  Transaction  $transaction
     * @return mixed
     */
    public function update(User $user, Transaction  $transaction)
    {
        return true;
    }
    /**
     * Determine whether the user can delete the Transaction.
     *
     * @param User  $user
     * @param  Transaction  $transaction
     * @return mixed
     */
    public function delete(User $user, Transaction  $transaction)
    {
        return true;
    }

}
