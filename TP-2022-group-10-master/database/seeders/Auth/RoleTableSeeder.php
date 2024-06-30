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
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder{
  /*
  * Controller
* manage = C(create,store),R(index,show)U(edit,update)D(destroy)
 * user = C(create,store),R(index,show),U(edit,update)
 * viewer = R(index,show)
 */

  private $defaultPermissionsForSuperAdmin = [
    'general',
    'profile.*',
  ];

  private $defaultPermissionsForUser = [
    'general',
    'profile.r',
    'profile.u',
    'ea.book_entry.r',
    'ea.expense.r',
    'ea.expense_type.r',
    'ea.expense_category.r',
    'eh.payroll.r',
    'eh.employee.r',
    'ei.supplier.r',
  ];

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    //step 1: define permission and save to the permission table
    $this->setPermission();
    //step 2: create role and populate permission to the role
    $this->populatePermissionToRoles();
  }

  protected function setPermission()
  {
    //get the permission list from the constant file
    $getPermissionConstants = config("constants.PERMISSION");
    //populate to the permission table
    foreach ($getPermissionConstants as $p){
      Permission::create(['name' => $p]);
    }
  }

  protected function populatePermissionToRoles()
  {

    $role = Role::create(['name' => config('constants.ROLE.SUPER-ADMIN')]);
    //$role->givePermissionTo(Permission::all());
    $role = Role::create(['name' => config('constants.ROLE.USER')]);
    //$role->givePermissionTo(Permission::all());

    //Role::create(['name' => config('constants.ROLE.SUPER-ADMIN')])->givePermissionTo($superAdminPermissions);
  }
}
