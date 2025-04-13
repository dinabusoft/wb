<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
   @property date $date_in date in
@property date $date_out date out
@property time $time_in time in
@property time $time_out time out
@property double $weight_in weight in
@property double $weight_out weight out
@property varchar $ref_no ref no
@property varchar $police_no police no
@property varchar $driver_name driver name
@property varchar $driver_phone driver phone
@property int $materials_id materials id
@property int $customers_id customers id
@property text $remark remark
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property timestamp $deleted_at deleted at
@property int $created_by created by
@property int $updated_by updated by
@property int $deleted_by deleted by
@property Customer $masterCustomer belongsTo
@property Material $masterMaterial belongsTo
   
 */
class Transaction extends Model 
{
    
    use SoftDeletes;
    /**
    * Database table name
    */
    protected $table = 'transactions';

    /**
    * Mass assignable columns
    */
    protected $fillable=[
'date_in',
'date_out',
'time_in',
'time_out',
'weight_in',
'weight_out',
'ref_no',
'police_no',
'driver_name',
'driver_phone',
'materials_id',
'customers_id',
'remark',
'created_by',
'updated_by',
'deleted_by'];

    /**
    * Date time columns.
    */
    protected $dates=['date_in',
'date_out',
'time_in',
'time_out'];

    /**
    * customer
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function customer()
    {
        return $this->belongsTo(MasterCustomer::class,'customers_id');
    }

    /**
    * material
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function material()
    {
        return $this->belongsTo(MasterMaterial::class,'materials_id');
    }


    /**
     * @return BelongsTo
     */
    public function created_actor()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /**
     * @return BelongsTo
     */
    public function updated_actor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return BelongsTo
     */
    public function deleted_actor()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }


}