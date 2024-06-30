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

namespace App\Models\EH\M1\Settings;
//TODO py potential M1 new module

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class EmploymentStatus extends Model implements Auditable
{

  use SoftDeletes;
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
  protected $table = 'eh_employment_statuses';
  protected $fillable = array(
    'employee_id',
    'effective_date',
    'job_type',
    'job_status',
    'leave_workflow',
    'workdays',
    'holidays',
    'term_start',
    'term_end',
    'remarks',
    'created_at',
    'updated_at'
  );
}
