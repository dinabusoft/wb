<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
   @property varchar $name name
@property int $port port
@property varchar $baudrate baudrate
@property varchar $databits databits
@property varchar $stopbits stopbits
@property varchar $parity parity
@property int $inputlen inputlen
@property varchar $threshold threshold
@property varchar $delimiter delimiter
@property int $index index
@property tinyint $status status
@property text $remark remark
@property text $log log
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property timestamp $deleted_at deleted at
@property int $created_by created by
@property int $updated_by updated by
@property int $deleted_by deleted by
   
 */
class Device extends Model 
{
    use SoftDeletes;
    /**
    * Database table name
    */
    protected $table = 'devices';

    /**
    * Mass assignable columns
    */
    protected $fillable=['deleted_by',
'name',
'port',
'baudrate',
'databits',
'stopbits',
'parity',
'inputlen',
'threshold',
'delimiter',
'index',
'status',
'remark',
'log',
'created_by',
'updated_by',
'deleted_by',
'user_id'];

    /**
    * Date time columns.
    */
    protected $dates=[];



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

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}