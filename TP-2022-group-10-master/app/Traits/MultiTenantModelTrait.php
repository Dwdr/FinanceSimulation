<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

trait MultiTenantModelTrait
{
  public static function bootMultiTenantModelTrait()
  {
    // if want to disable global super-admin, just delete if checking.
    if (!app()->runningInConsole() && auth()->check() && Request::header('Clixells-App')!='hr-system') {

      $isAdmin = auth()->user()->hasRole(config('constants.ROLE.SUPER_ADMIN'));
      static::creating(function ($model) use ($isAdmin) {

        if (!$isAdmin) {
          $model->organization_id = auth()->user()->profile->organization_id;
        }
      });
      if (!$isAdmin) {
        static::addGlobalScope('organization_id', function (Builder $builder) {
          $field = sprintf('%s.%s', $builder->getQuery()->from, 'organization_id');
//TODO fix org id later
//          $builder->where($field, auth()->user()->profile->organization_id)->orWhereNull($field);
        });
      }

    }
  }
}
