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

class SMGenerator extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  //protected $signature = 'sm:gen {name : Class (singular) for example User}';
  protected $signature = 'sm:gen';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Staymgt Generator';

  private $basicData = null;
  private $fieldsData = null;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return void
   */
  public function handle(){
    //get stub json file list
    $file_list = array_diff(scandir(resource_path("_stubs_data_file")), array('..', '.'));
    //ask developer which json file needed
    $file = $this->anticipate('What file?', $file_list);

    //set data
    $this->setBasicData($file);
    $this->setFieldsData($file);

    //generate model
    if($this->confirm('Generate Model?')){
      $this->generateModel();
    }
    //generate view
    if($this->confirm('Generate View (Index)?')){
      $this->generateViewIndex();
    }
    if($this->confirm('Generate View (Detail)?')){
      $this->generateViewDetail();
    }
    if($this->confirm('Generate View (Partial)?')){
      $this->generateViewPartial();
    }
    //generate controller
    if($this->confirm('Generate Controller?')){
      $this->generateController();
    }
    //generate migration
    if($this->confirm('Generate Migration?')){
      $this->generateMigration();
    }
    //generate translation
    if($this->confirm('Generate Language?')){
      $this->generateTranslation();
    }
  }

  //get data file
  protected function getDatafile($datafile){
    return file_get_contents(resource_path("_stubs_data_file/$datafile"));
  }
  //get set basic data
  protected function getBasicData($element){
    return $this->basicData[$element];
  }
  protected function setBasicData($datafile){
    //get json file contents
    $df = $this->getDatafile($datafile);
    //decode json
    $d  = json_decode($df, TRUE);
    //break into basic and fields data array
    $this->basicData=$d["basic"];
  }
  //get set fields data
  protected function getFieldsData(){
    return $this->fieldsData;
  }
  protected function setFieldsData($datafile){
    //get json file contents
    $df = $this->getDatafile($datafile);
    //decode json
    $d  = json_decode($df, TRUE);
    //break into basic and fields data array
    $this->fieldsData=$d["fields"];
  }
  //Model related
  protected function getModelStub(){
    return file_get_contents(resource_path("_stubs_templates/model.stub"));
  }
  protected function generateModel(){
    $file_name=str_singular(studly_case($this->getBasicData('module')));
    //generate fields string
    $replace = "";
    $fields = $this->getFieldsData();
    foreach ($fields as $f){
      $replace .= "'".$f['field']."',";
      $replace .= "
          ";
    }
    $replace .= "'created_at',";
    $replace .= "
          ";
    $replace .= "'updated_at',";
    //replace fields
    $search="{{fields}}";
    $output = str_replace($search, $replace, $this->getModelStub());
    //replace basic data
    $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $output);
    //generate model
    file_put_contents(app_path("/Models/_stubs/{$file_name}.php"), $output);
  }
  //View related
  protected function getViewIndexStub(){
    return file_get_contents(resource_path("_stubs_templates/view/index.stub"));
  }
  protected function generateViewIndex(){
    //config
    $output_path = resource_path("views/_stubs/index.blade.php");
    //generate content
    $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $this->getViewIndexStub());
    file_put_contents($output_path, $output);
  }
  protected function getViewDetailStub(){
    return file_get_contents(resource_path("_stubs_templates/view/detail.stub"));
  }
  protected function generateViewDetail(){
    //config
    $output_path = resource_path("views/_stubs/detail.blade.php");
    //replace basic data
    $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $this->getViewDetailStub());
    //replace components
    $search='{{components}}';
    $replace=$this->generateViewDetailComponents();
    $output = str_replace($search, $replace, $output);
    //save output
    file_put_contents($output_path, $output);
  }
  protected function getViewDetailComponentStub($type){
    return file_get_contents(resource_path("_stubs_templates/view/components/$type.stub"));
  }
  protected function generateViewDetailComponents(){
    $components = "";
    //replace fields data
    $fields = $this->getFieldsData();
    $search='{{field}}';
    foreach ($fields as $f){
      $replace=$f['field'];
      $components .= str_replace($search, $replace, $this->getViewDetailComponentStub($f['field_type']));
      $components .= "
          ";
    }
    //replace basic data
    $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $components);
    return $output;
  }
  protected function getViewPartialStub($type){
    return file_get_contents(resource_path("_stubs_templates/view/partial/$type.stub"));
  }
  protected function generateViewPartial(){
    //generate content
    $files=[
      "index/panel",
      "index/script_table",
      "detail/panel",
      "detail/script_datepicker",
      "detail/script_validation"
    ];

    foreach($files as $f){
      $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $this->getViewPartialStub($f));
      file_put_contents(resource_path("views/_stubs/{$f}.blade.php"), $output);
    }
  }
  //Controller related
  protected function getControllerStub(){
    return file_get_contents(resource_path("_stubs_templates/controller.stub"));
  }
  protected function generateController(){
    //generate content
    $file_name=str_singular(studly_case($this->getBasicData('module')));
    $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $this->getControllerStub());
    file_put_contents(app_path("/Http/Controllers/_stubs/{$file_name}Controller.php"), $output);
  }
  //Migration related
  protected function getMigrationStub(){
    return file_get_contents(resource_path("_stubs_templates/migration.stub"));
  }
  protected function generateMigration(){
    $name_space=strtolower($this->getBasicData('name_space'));
    $module_name=str_plural(snake_case($this->getBasicData('module')));
    //generate fields string
    $replace = "";
    $fields = $this->getFieldsData();
    foreach ($fields as $f){
      $replace .= '$table->'.$f['mysql_type']."('".$f['field']."')";
      if($f['nullable']){
        $replace .= '->nullable()';
      }
      $replace .= ";
          ";
    }
    $replace .= '$table->softDeletes();';
    $replace .= "
          ";
    $replace .= '$table->timestamps();';
    //replace fields
    $search="{{fields}}";
    $output = str_replace($search, $replace, $this->getMigrationStub());
    //replace basic data
    $output = str_replace($this->getBasicDataSearch(), $this->getBasicDataReplace(), $output);
    //generate model
    $y=date('Y');
    $m=date('m');
    $d=date('d');
    $time=date('His');
    $file_name=$y."_".$m."_".$d."_".$time."_create_{$name_space}_{$module_name}_table";
    file_put_contents(database_path("_stubs/{$file_name}.php"), $output);
  }
  //Translation related
  protected function getTranslationStub(){
    return file_get_contents(resource_path("_stubs_templates/language.stub"));
  }
  protected function generateTranslation(){
    //generate content
    $name=$this->getBasicData('file');
    //generate fields string
    $replace = "";
    $fields = $this->getFieldsData();
    foreach ($fields as $f){
      $replace .= "'".$f['field']."' => '".$f['field']."',";
      $replace .= "
          ";
    }
    //replace fields
    $search="{{fields}}";
    $output = str_replace($search, $replace, $this->getTranslationStub());
    file_put_contents(resource_path("lang/_stubs/{$name}.php"), $output);
  }
  //String replace basic data
  protected function getBasicDataSearch(){
    return $basicDataSearch=[
      '{{name_space_upper_case}}',
      '{{name_space_lower_case}}',
      '{{module_singular_snack}}',
      '{{module_plural_snack}}',
      '{{module_singular_studly}}',
      '{{module_plural_studly}}',
    ];
  }
  protected function getBasicDataReplace(){
    return $basicDataReplace=[
      strtoupper($this->getBasicData('name_space')),
      strtolower($this->getBasicData('name_space')),
      str_singular(snake_case($this->getBasicData('module'))),
      str_plural(snake_case($this->getBasicData('module'))),
      str_singular(studly_case($this->getBasicData('module'))),
      str_plural(studly_case($this->getBasicData('module'))),
    ];
  }





  /*****
   * Reference

   *

  //$generated.=$this->date_picker_generator($f['name'],$f['var'],$f['translation_file']);
  //File::append(base_path('routes/api.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');");
   *
   *
  if(!file_exists($path = app_path('/Http/Requests')))
  mkdir($path, 0777, true);
   *
   * */
}
