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

namespace App\Models\EH\SystemSettings;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use OwenIt\Auditing\Contracts\Auditable;

//class Expense extends Model implements Auditable
class LeaveTypeVisible extends Model {

    use SoftDeletes;

    //use \OwenIt\Auditing\Auditable;

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
    protected $table = 'eh_settings_leave_type_visible';
    protected $fillable = array(

    );

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'deleted_at'
    ];

    public function leaveType() {
        return $this->belongsTo(LeaveType::class, 'leave_type_id', 'id');
    }


}
