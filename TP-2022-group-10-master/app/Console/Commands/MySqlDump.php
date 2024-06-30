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

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MySqlDump extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'db:dump';
  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Runs the mysqldump utility using info from .env';
  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $ds = DIRECTORY_SEPARATOR;
    $host = env('DB_HOST');
    $username = env('DB_USERNAME');
    $password = env('DB_PASSWORD');
    $database = env('DB_DATABASE');

    $ts = time();
    $path = database_path() . $ds . 'backups' . $ds . date('Y', $ts) . $ds . date('m', $ts) . $ds . date('d', $ts) . $ds;
    $file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';
    $command = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username, $password, $database, $path . $file);
    if (!is_dir($path)) {
      mkdir($path, 0755, true);
    }
    exec($command);
  }
}
