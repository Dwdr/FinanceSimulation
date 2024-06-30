<?php

namespace App\Models\System;

//TODO jl can this file delete?

use App\Models\Auth\Organization;
use App\Models\CS\Album;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class File extends Model implements Auditable
{
  use SoftDeletes, MultiTenantModelTrait;
  use \OwenIt\Auditing\Auditable;

  /**
   * Indicates if the model should be timestamped.
   * Indicates if the model should be id incremental.
   * Indicates the attribute name of the primary key.
   * Indicates the attribute type of the primary key.
   *
   * @var bool
   * @var bool
   * @var bool
   * @var bool
   */
  public $timestamps = true;
  public $incrementing = true;
  protected $primaryKey = 'id';
  protected $keyType = 'integer';
  protected $connection = 'mysql';

  /**
   * The table associated with the model.
   * The fillable array.
   *
   * @var string
   * @var array
   */
  protected $table = 'sys_files';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  public function organization(){
    return $this->belongsTo(Organization::class);
  }

  public function album(){
    return $this->belongsToMany(Album::class,'cs_albums_files');
  }

  public function thumb(){
    return $this->belongsTo(static::class,'ref_file_id','id')->where('ref_type',config('constants.FILE_REF_TYPE.ALBUM_THUMB'));
  }

}
