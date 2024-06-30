<?php

namespace App\Models\Panel\Settings\Systems;

use Illuminate\Database\Eloquent\Model;

class GlobalConfig extends Model
{

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'settings_sys_global_config';

  /**
   * Indicates if the model should be timestamped.
   *
   * @var bool
   */
  public $timestamps = true;

  /**
   * Attribute
   */

  public function getConfigAttribute($value){
    return unserialize($value);
  }
}
