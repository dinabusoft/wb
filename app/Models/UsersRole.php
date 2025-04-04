<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
   @property varchar $roles roles
@property bigint $userd_id userd id
   
 */
class UsersRole extends Model 
{
    /**
    * Database table name
    */
    protected $table = 'users_roles';

    /**
    * Mass assignable columns
    */
    protected $fillable=[
'roles',
'user_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];




}