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

namespace App\Models\EH;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Models\EH\Employee\EmployeeLog;
use App\Models\EH\Employee\EmployeeMovement;
use App\Models\EH\Employee\EmployeeTermination;
use App\Models\EH\M1\LeaveRecord;
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
use App\Models\EH\M1\EmployeePackage;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Employee extends Model implements AuditableContract{

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
    protected $table = 'eh_employees';
    protected $fillable = array(   
        'uuid',
        'user_id',
        'first_name',
        'last_name',
        'email',
    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function getAvatarFileAttribute($value){
        return unserialize($value);
    }

    public function getHkidImageAttribute($value){
        return unserialize($value);
    }

    public function getBankCardImageAttribute($value){
        return unserialize($value);
    }

    public function getSupportDocumentsAttribute($value){
        return unserialize($value);
    }

    public function creator(){
        return $this->belongsTo(User::class,'creator_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function title(){
        return $this->belongsTo(Title::class);
    }

    public function employeeType(){
        return $this->belongsTo(EmployeeType::class,'employee_type_id');
    }
    
    public function directSupervisor(){
        return $this->belongsTo(User::class, 'direct_supervisor_id','id');
    }

}
