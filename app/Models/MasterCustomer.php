<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
   @property varchar $name name
@property varchar $street street
@property varchar $district district
@property varchar $regency regency
@property varchar $province province
@property varchar $postalcode postalcode
@property varchar $telephone telephone
@property varchar $phone phone
@property tinyint $status status
@property text $remark remark
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property timestamp $deleted_at deleted at
@property int $created_by created by
@property int $updated_by updated by
@property int $deleted_by deleted by
@property \Illuminate\Database\Eloquent\Collection $transaction hasMany
   
 */
class MasterCustomer extends Model 
{
    use SoftDeletes;
    
    /**
    * Database table name
    */
    protected $table = 'master_customers';

    /**
    * Mass assignable columns
    */
    protected $fillable=['deleted_by',
'name',
'street',
'district',
'regency',
'province',
'postalcode',
'telephone',
'phone',
'status',
'remark',
'created_by',
'updated_by',
'deleted_by'];

    /**
    * Date time columns.
    */
    protected $dates=[];

    /**
    * transactions
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function transactions()
    {
        return $this->hasMany(Transaction::class,'customers_id');
    }



}