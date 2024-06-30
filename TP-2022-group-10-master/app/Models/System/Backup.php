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

namespace App\Models\System;

use App\Models\Auth\Organization;
use App\Traits\MultiTenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Backup extends Model {

    use SoftDeletes;
    use MultiTenantModelTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $timestamps = true;
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'uuid';
    protected $connection = 'mysql';

    protected $table = 'sys_backup';

    protected $fillable = array(
        'uuid',
        'organization_id',
        'file',
        'created_at',
        'updated_at'
    );

    public function getFileAttribute($value){
        return unserialize($value);
    }

    public function organization() {
        return $this->belongsTo(Organization::class);
    }
}
