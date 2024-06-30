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

namespace App\Models\EH\M1;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePackage extends Model
{

    use SoftDeletes;
    use MultiTenantModelTrait;

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
    protected $table = 'm1_employee_packages';
    protected $fillable = array(
        'organization_id',
        'creator_id',
        'employee_uuid',
        'effective_date',
        'basic_salary',
        'mpf_employer_compulsory',
        'mpf_employer_voluntary',
        'mpf_employee_compulsory',
        'mpf_employee_voluntary',
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
        'deleted_at'
    ];

    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }

    public function employeeType(){
        return $this->belongsTo(EmployeeType::class,'employee_type_id');
    }
}
