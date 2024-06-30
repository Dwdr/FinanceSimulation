<?php
/*
 * Kamphora CONFIDENTIAL
 * Copyright (c) 2020.
 * ------------------------------------
 * [2002] - [2020] Kamphora Limited (Hong Kong)
 *  All Rights Reserved.
 *
 *  NOTICE:  All information contained herein is, and remains
 *  the property of Kamphora Limited (Hong Kong) and its affiliated parties,
 *  if any. The intellectual and technical concepts contained
 *  herein are proprietary to Kamphora Limited (Hong Kong)
 *  and its affiliated parties and may be covered by U.S. and Foreign Patents,
 *  patents in process, and are protected by trade secret or copyright law.
 *  Dissemination of this information or reproduction of this material
 *  is strictly forbidden unless prior written permission is obtained
 *  from Kamphora Limited (Hong Kong).
 *
 *  This file is subject to the terms and conditions defined in
 *  file 'LICENSE.txt', which is part of this source code package.
 *
 *  Should you require any further information,
 *  please contact info@Kamphora.com
 */

namespace App\Models\Jobs;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Models\EH\Employee\EmployeeMovement;
use App\Models\EH\Configurations\Bank;
use App\Models\EH\Configurations\Department;
use App\Models\EH\Configurations\Designation;
use App\Models\EH\Configurations\EmployeeType;
use App\Models\EH\Configurations\Gender;
use App\Models\EH\Configurations\Grade;
use App\Models\EH\Configurations\HighestEducation;
use App\Models\EH\Configurations\MartialStatus;
use App\Models\EH\Configurations\Nationality;
use App\Models\EH\Configurations\Relationship;
use App\Models\EH\Configurations\Title;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Seeker extends Model implements AuditableContract{

    use SoftDeletes;
    use MultiTenantModelTrait;
    use HasFactory;
    use Auditable;

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
    protected $keyType = 'uuid';
    protected $connection = 'mysql';

    /**
     * The table associated with the model.
     * The fillable array.
     *
     * @var string
     * @var array
     */
    protected $table = 'jobs_seekers';
    protected $fillable = array(
        'uuid',
        'organization_id',
        'creator_id',
        'name',
        'introduction',
        'email',
        'contact_number',
        'configurations',
        'created_at',
        'updated_at'
    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'organization_id',
        'creator_id',
        'employee_uuid',
        'deleted_at'
    ];

    public function organization(){
        return $this->belongsTo(Organization::class);
    }
}
