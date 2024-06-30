<?php

namespace App\Models\System;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOrder extends Model {
    use SoftDeletes, MultiTenantModelTrait;

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
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     * The fillable array.
     *
     * @var string
     * @var array
     */
    protected $table = 'sys_job_orders';
    protected $fillable = [
        'uuid',
        'organization_id',
        'creator_id',
        'type',
        'payload',
        'effective_type',
        'effective_date',
        'job_count',
        'success_record',
        'fail_record',
        'status',
        'created_at',
        'updated_at'
    ];

    public function getPayloadAttribute($value){
        return unserialize($value);
    }

    public function getSuccessRecordAttribute($value){
        return unserialize($value);
    }

    public function getFailRecordAttribute($value){
        return unserialize($value);
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }

}
