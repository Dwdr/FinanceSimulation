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

namespace App\Policies\EH;

use App\Models\Auth\Permission;
use App\Models\EH\Employee;
use App\Models\Auth\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy {

    use HandlesAuthorization;

    public function index() {

    }

    public function create(User $user) {
        if ($user->can(Permission::EH_EMPLOYEE_C)) {
            return true;
        }
    }

    public function store(User $user) {
        if ($user->can(Permission::EH_EMPLOYEE_C)) {
            return true;
        }
    }


    public function show(User $user) {
        if ($user->can(Permission::EH_EMPLOYEE_R)) {
            return true;
        }
    }

    public function payslip() {

    }

    public function payslip_check() {

    }

    public function payslip_sample() {

    }

    public function clone() {

    }

    public function edit(User $user) {
        if ($user->can(Permission::EH_EMPLOYEE_R)) {
            return true;
        }
    }

    public function update(User $user) {
        if ($user->can(Permission::EH_EMPLOYEE_R)) {
            return true;
        }
    }

    public function destroy(User $user) {
        if ($user->can(Permission::EH_EMPLOYEE_D)) {
            return true;
        }
    }

    public function resetPassword() {

    }

    public function checkUser() {

    }

    public function job_application() {

    }

}
