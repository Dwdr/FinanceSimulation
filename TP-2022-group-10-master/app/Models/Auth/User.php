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

namespace App\Models\Auth;

use App\Models\EH\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;


//for package 'spatie/laravel-permission'
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable, CanResetPasswordContract
{
    use Notifiable;
    use HasApiTokens;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use HasRoles;
    use HasFactory;
    use CanResetPassword;

    //for package 'spatie/laravel-permission'

    protected $table = 'sys_users';
    protected $connection = 'mysql';
    //protected $connection = 'mysql-authentication-data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','is_active','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile() {
        return $this->hasOne(UserProfile::class);
    }

    public function oauth() {
        return $this->hasMany(UserOAuth::class);
    }

    public function employee() {
        return $this->hasOne(Employee::class);
    }

    public function holding(){
        return $this->hasMany(Holding::class);
    }

    public function historicalTransaction(){
        return $this->hasMany(historicalTransaction::class);
    }
}
