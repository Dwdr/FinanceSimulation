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

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PermissionTableSeeder extends Seeder {
    /*
     * Controller
     * manage = C(create,store),R(index,show)U(edit,update)D(destroy)
     * user = C(create,store),R(index,show),U(edit,update)
     * viewer = R(index,show)
     */

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTable();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->setPermission();
        $this->setRole();
//        $this->populatePermissionToRoles();
    }

    protected function truncateTable()
    {
        DB::table('sys_spatie_model_has_permissions')->delete();
        DB::table('sys_spatie_model_has_roles')->delete();
        DB::table('sys_spatie_role_has_permissions')->delete();
        DB::table('sys_spatie_permissions')->delete();
        DB::table('sys_spatie_roles')->delete();
    }

    protected function setPermission()
    {
        $this->command->getOutput()->progressStart();
        foreach (config("constants.PERMISSION") as $p) {
            Permission::create(['name' => $p]);
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();
    }

    protected function setRole()
    {
        $this->command->getOutput()->progressStart();
        foreach(config('constants.ROLE') as $r){
            $role = Role::create(['name' => $r]);
            $role->givePermissionTo(Permission::all());
            $this->command->getOutput()->progressAdvance();
        }
        $this->command->getOutput()->progressFinish();

//        $role = Role::create(['name' => config('constants.ROLE.SUPER_ADMIN')]);
//        $role->givePermissionTo(Permission::all());
//        $role = Role::create(['name' => config('constants.ROLE.ADMIN')]);
//        $role->givePermissionTo(Permission::all());
//        $role = Role::create(['name' => config('constants.ROLE.USER')]);
//        $role->givePermissionTo($this->defaultPermissionsForUser);
//        $role = Role::create(['name' => config('constants.ROLE.JOBS-EMPLOYER')]);
//        $role->givePermissionTo($this->defaultPermissionsForUser);
//        $role = Role::create(['name' => config('constants.ROLE.JOBS-SEEKER')]);
//        $role->givePermissionTo($this->defaultPermissionsForUser);
//        Role::create(['name' => config('constants.ROLE.SUPER_ADMIN')])->givePermissionTo($superAdminPermissions);
    }

    protected function populatePermissionToRoles()
    {
        $this->defaultPermissionsForUser = [
            config('constants.PERMISSION.ACCOUNT-ALL'),
            config('constants.PERMISSION.EH-LEAVE-APPLICATION-C'),
            config('constants.PERMISSION.EH-LEAVE-APPLICATION-R'),
            config('constants.PERMISSION.EH-LEAVE-APPLICATION-U'),
            config('constants.PERMISSION.EH-CHECK-IO-R'),
        ];
    }
}
