<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
   @property varchar $code code
@property varchar $name name
@property varchar $pack pack
@property varchar $content content
@property text $remark remark
@property tinyint $status status
@property timestamp $created_at created at
@property timestamp $updated_at updated at
@property timestamp $deleted_at deleted at
@property int $created_by created by
@property int $updated_by updated by
@property int $deleted_by deleted by
@property \Illuminate\Database\Eloquent\Collection $transaction hasMany
   
 */
class MasterMaterial extends Model 
{
    use SoftDeletes;

    /**
    * Database table name
    */
    protected $table = 'master_materials';

    /**
    * Mass assignable columns
    */
    protected $fillable=['deleted_by',
'code',
'name',
'pack',
'content',
'remark',
'status',
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
        return $this->hasMany(Transaction::class,'materials_id');
    }



}