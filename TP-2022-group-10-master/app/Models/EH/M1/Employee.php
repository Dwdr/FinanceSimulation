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
//TODO py potential M1 new module

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Employee extends Model implements Auditable
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
  protected $table = 'eh_employees';
  protected $fillable = array(
    'employee_id',
    'prefix',
    'first_name',
    'middle_name',
    'last_name',
    'suffix',
    'gender',
    'dob',
    'photo',
    'nationality',
    'national_id',
    'passport_id',
    'ethnicity',
    'religions',
    'joined_date',
    'probation_start_date',
    'probation_end_date',
    'is_time_clock_needed',
    'basic_salary',
    'effective_date',
    'currency',
    'next_review_date',
    'variable_pay',
    'variable_deduction',
    'bonus',
    'statutory_contribution',
    'bank',
    'payment_interval',
    'iban_bank_account',
    'method',
    'martial_status',
    'num_of_children',
    'is_spouse_working',
    'spouse_first_name',
    'spouse_middle_name',
    'spouse_last_name',
    'spouse_gender',
    'spouse_dob',
    'spouse_nationality',
    'spouse_national_id',
    'spouse_passport_id',
    'spouse_ethnicity',
    'spouse_religions',
    'children_first_name',
    'children_middle_name',
    'children_last_name',
    'children_gender',
    'children_dob',
    'is_children_married',
    'email',
    'homepage',
    'office_phone',
    'mobile_phone',
    'home_phone',
    'address_line_1',
    'address_line_2',
    'address_city',
    'address_postcode',
    'address_state',
    'address_country',
    'emergency_contact_first_name',
    'emergency_contact_middle_name',
    'emergency_contact_last_name',
    'emergency_contact_relationship',
    'emergency_contact_office_phone',
    'emergency_contact_mobile_phone',
    'emergency_contact_home_phone',
    'height',
    'weight',
    'blood_type',
    'vision_left',
    'vision_right',
    'hearing_left',
    'hearing_right',
    'hand_left',
    'hand_right',
    'lag_left',
    'lag_right',
    'is_directory_access_allowed',
    'data_accessible_level',
    'remarks',
    'created_at',
    'updated_at'
  );

  /**
   * Attribute
   */
  public function getDetailsAttribute($value){
        return unserialize($value);

  }

  /**
   * Relationship
   */
  public function payrolls()
  {
    return $this->hasMany(Payroll::class);
  }
}
