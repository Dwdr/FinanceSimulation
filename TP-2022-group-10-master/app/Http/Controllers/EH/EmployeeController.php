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

namespace App\Http\Controllers\EH;

use App\Models\Auth\Organization;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\EH\Employee;
use App\Http\Controllers\Controller;
use App\Models\EH\Employee\EmployeeLog;
use App\Models\EH\Employee\EmployeePersonnelChange;
use App\Models\EH\JobApplication;
use App\Models\EH\LeaveBalance;
use App\Models\EH\Configurations\Holiday;
use App\Models\EH\M1\PayrollRecord;
use App\Models\EH\Configurations\Bank;
use App\Models\EH\Configurations\Department;
use App\Models\EH\Configurations\Designation;
use App\Models\EH\Configurations\EmployeeType;
use App\Models\EH\Configurations\Gender;
use App\Models\EH\Configurations\Grade;
use App\Models\EH\Configurations\HighestEducation;
use App\Models\EH\Configurations\LeaveType;
use App\Models\EH\Configurations\MartialStatus;
use App\Models\EH\Configurations\Nationality;
use App\Models\EH\Configurations\Relationship;
use App\Models\EH\Configurations\Title;
use App\Models\EH\SystemSettings\EmailTemplateType;
use App\Traits\EmployeeAuditLog;
use DateTime;
use File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Type;

class EmployeeController extends Controller {

    use EmployeeAuditLog;

    /**
     * Classified the detail blade view into 4 modes
     * isModeShow, isModeCreate, isModeClone, and isModeEdit
     *
     * @return void
     */
    private $mode = [
        'isModeShow' => false,
        'isModeCreate' => false,
        'isModeEdit' => false,
        'isModeClone' => false,
    ];
    private $msg_auth_reject = "You are not authorized for the module";
    private $validation_rules = [
        // TODO
        'employee_id' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email|unique:sys_users',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Show the index page (list view) for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function index() {
        $employees = Employee::with([
            'department',
            'designation',
            'employeeType',
            'user',
        ])->select(
            'uuid',
            'organization_id',
            'type',
            'employee_id',
            'first_name',
            'last_name',
            'department_id',
            'designation_id',
            'employee_type_id',
            'avatar_file',
            'user_id'

        )->get();
        $personnel_change_count = EmployeeLog::where('type', config('constants.EMPLOYEE_LOG.TYPE.PERSONAL'))
            ->where('status', config('constants.EMPLOYEE_LOG.STATUS.SUBMITTED'))
            ->count();
        return view('eh.employee.index', compact('employees', 'personnel_change_count'));
    }

    /**
     * Show the employee contact page (list view) for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function directory() {
        $employees = Employee::with([
            'department',
            'designation',
            'employeeType',
        ])->select(
            'uuid',
            'organization_id',
            'employee_id',
            'first_name',
            'last_name',
            'address',
            'email',
            'department_id',
            'designation_id',
            'employee_type_id',
            'avatar_file',
            'tel',
            'alias',

        )->orderBy('employee_id')->paginate(9);
        return view('eh.directory.index', compact('employees', ));
    }

    /**
     * Show the create page for the function.
     *
     * @return RedirectResponse
     * @return View
     */
    public function create() {
        $this->mode['isModeCreate'] = true;
        $genders = Gender::where('is_active', true)->get();
        $martial_status = MartialStatus::where('is_active', true)->get();
        $nationalities = Nationality::where('is_active', true)->get();
        $titles = Title::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        $relationships = Relationship::where('is_active', true)->get();
        $employee_types = EmployeeType::where('is_active', true)->get();
        $banks = Bank::where('is_active', true)->get();
        $grades = Grade::where('is_active', true)->get();
        $highest_educations = HighestEducation::where('is_active', true)->get();
        $employees = Employee::all();
        return view('eh.employee.detail', compact('genders', 'grades', 'highest_educations', 'banks', 'martial_status', 'nationalities', 'titles', 'departments', 'designations', 'relationships', 'employee_types', 'employees'))->with('mode', $this->mode);
    }

    /**
     * Store the input value inputted from create page
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request) {

        $msg_store_success = "Employee created.";

        $request->validate($this->validation_rules);
        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $data['organization_id'] = Auth::user()->profile->organization_id;
        $data['creator_id'] = Auth::user()->id;

        //Create user login
        $password_text = Str::random(8);
        $password = Hash::make($password_text);
        $account = User::create([
            'password' => $password,
            'email' => $request->email,
        ]);
        //Create User Profile
        $profile = UserProfile::create([
            'user_id' => $account->id,
            'organization_id' => Auth::user()->profile->organization_id,
            'name' => $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'contacts' => $request->tel,
            'address' => $request->address,
            'dob' => $request->date_of_birth,
            'avatar_id' => null,
            'status' => true,
        ]);
        $data['user_id'] = $account->id;
        $data['hkid_image'] = serialize($this->fileUpload($request->hkid_image, "hkid_image", $data['uuid']));
        $data['bank_card_image'] = serialize($this->fileUpload($request->bank_card_image, "bank_card_image", $data['uuid']));
        $data['support_documents'] = serialize($this->fileUpload($request->support_documents, "support_documents", $data['uuid']));

        $data['avatar_file'] = serialize([]);

        if ($data['probation_end_date'] < date('Y-m-d')) {
            $data['type'] = config('constants.EMPLOYEE.TYPE.REGULAR');
        } else {
            $data['type'] = config('constants.EMPLOYEE.TYPE.TRIAL');
        }

        $account->assignRole(config('constants.ROLE.USER'));

        $employee = Employee::create($data);

        if (isset($request->file_name)) {
            $storage_path = 'uploads/eh/' . Auth::user()->profile->organization->name_slug . '/employee/temp/avatar/';
            $storage_to_path = 'uploads/eh/' . Auth::user()->profile->organization->name_slug . '/employee/' . $data['uuid']->toString() . '/avatar/';
            $folderPath = storage_path('app/private/' . $storage_path);
            $folderToPath = storage_path('app/private/' . $storage_to_path);
            // create file and folder
            if (!file_exists($folderToPath)) {
                mkdir($folderToPath, 0777, true);
            }
            File::move($folderPath . '/' . $request->file_name, $folderToPath . '/' . $request->file_name);
            $avatar = [
                'file_name' => $request->file_name,
                'file_source_name' => $request->file_source_name,
                'file_path' => $storage_to_path,
                'file_size' => $request->file_size,
                'file_type' => 'image',
                'file_extension' => 'jpg',
            ];
            $data['avatar_file'] = serialize($avatar);
            $employee->avatar_file = $data['avatar_file'];
            $employee->save();
        }

        $this->makeLog($employee->uuid, 'employee', config('constants.EMPLOYEE_LOG.EVENT.CREATED'));

        // Send email to employee
        $email_data = [
            'source_email' => 'info@clixells.com', // TODO change to company config
            'recipient_email' => [],
            'data' => [
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $account->email,
                'password' => $password_text,
            ]
        ];
        array_push($email_data['recipient_email'], $account->email);
        $this->sendEmail(EmailTemplateType::MSG_EP_0001, $email_data);


        // TODO cal employee balance
//            $leave_type = LeaveType::all();
//            foreach($leave_type as $lt){
//                $this->setEmployeeBalance($lt,$employee->join_date,$employee->uuid->toString());
//            }

        session()->flash('message', $msg_store_success . ' [DEBUG] Login Password: ' . $password_text);
        return redirect()->route("eh.employee.show", $employee->uuid);
    }

    /**
     * Show the selected entry record by key-in the primary ID
     *
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return View
     */
    public function show($uuid) {
        $this->mode['isModeShow'] = true;

        $e = Employee::findOrFail($uuid);
        $log = EmployeeLog::with('creator.employee')->where('employee_uuid', $uuid)
            ->where('type', config('constants.EMPLOYEE_LOG.TYPE.LOG'))
            ->orderBy('created_at', 'desc')->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });
        $movement = EmployeeLog::with('creator.employee')->where('employee_uuid', $uuid)
            ->where('type', config('constants.EMPLOYEE_LOG.TYPE.CAREER'))
            ->orderBy('created_at', 'desc')->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });
        return view('eh.employee.detail', compact('e', 'log','movement'))->with('mode', $this->mode);
    }

    /**
     * Payslip
     *
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return View
     */
    public function payslip($uuid) {
        $e = Employee::findOrFail($uuid);
        $holiday_list = Holiday::all();
        return view('eh.payroll.generator', compact('e','holiday_list'));
    }

    public function payslip_check($uuid) {
        $view_accept = "eh.payroll.generator_check";
        $payroll = PayrollRecord::findOrFail($uuid);
        $e = Employee::findOrFail($payroll->employee_uuid);
        $holiday_list = Holiday::all();
        return view('eh.employee.index', compact('payroll','e','holiday_list'));
    }

    public function payslip_sample() {
        $view_accept = "eh.payroll.sample";
        return view($view_accept);
    }

    /**
     * Show the clone page for the selected record.
     *
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return View
     */
    public function clone($uuid) {
        //function config
        $route_reject = "eh.dashboard.index";
        $view_accept = "eh.employee.detail";
        $auth = config("constants.PERMISSION.EH-EMPLOYEE-C");
        $this->mode['isModeClone'] = true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //if authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //authorization accept
            $e = Employee::findOrFail($uuid);
            $genders = Gender::where('is_active', true)->get();
            $martial_status = MartialStatus::where('is_active', true)->get();
            $nationalities = Nationality::where('is_active', true)->get();
            $titles = Title::where('is_active', true)->get();
            $departments = Department::where('is_active', true)->get();
            $designations = Designation::where('is_active', true)->get();
            $relationships = Relationship::where('is_active', true)->get();
            $employee_types = EmployeeType::where('is_active', true)->get();
            $banks = Bank::where('is_active', true)->get();
            $grades = Grade::where('is_active', true)->get();
            $highest_educations = HighestEducation::where('is_active', true)->get();
            $employees = Employee::all();
            return view('eh.employee.index', compact('e', 'highest_educations', 'genders', 'grades', 'banks', 'martial_status', 'nationalities', 'titles', 'departments', 'designations', 'relationships', 'employee_types', 'employees'))->with('mode', $this->mode);
        }
    }

    /**
     * Show the edit page for the selected record.
     *
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return View
     */
    public function edit($uuid) {
        //function config
        $route_reject = "eh.dashboard.index";
        $view_accept = "eh.employee.detail";
        $auth = config('constants.PERMISSION.EH-EMPLOYEE-U');
        $this->mode['isModeEdit'] = true;

        //check authorization
        if (!auth()->user()->can($auth)) {
            //if authorization reject
            //show warning
            session()->flash('alert-warning', $this->msg_auth_reject);
            //redirect to reject page
            return redirect()->route($route_reject);
        } else {
            //authorization accept
            //check if the record editing is belongs to the user
            //TODO we should check if the record editing is belongs to the user
            $e = Employee::findOrFail($uuid);
            $genders = Gender::where('is_active', true)->get();
            $martial_status = MartialStatus::where('is_active', true)->get();
            $nationalities = Nationality::where('is_active', true)->get();
            $titles = Title::where('is_active', true)->get();
            $departments = Department::where('is_active', true)->get();
            $designations = Designation::where('is_active', true)->get();
            $relationships = Relationship::where('is_active', true)->get();
            $employee_types = EmployeeType::where('is_active', true)->get();
            $banks = Bank::where('is_active', true)->get();
            $grades = Grade::where('is_active', true)->get();
            $highest_educations = HighestEducation::where('is_active', true)->get();
            $employees = Employee::where('uuid', '<>', $e->uuid)->get();
            return view($view_accept, compact('e', 'highest_educations', 'genders', 'grades', 'banks', 'martial_status', 'nationalities', 'titles', 'departments', 'designations', 'relationships', 'employee_types', 'employees'))->with('mode', $this->mode);
        }
    }

    /**
     * Update the input value inputted from create page
     *
     * @param Request $request
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return RedirectResponse
     */
    public function update(Request $request, $uuid) {
        $msg_update_success = "Employee updated.";

        $e = Employee::findOrFail($uuid);
        $validate = $this->validation_rules;
        $validate['email'] = 'required|email|unique:sys_users,email,' . $e->user->id;
        $request->validate($validate);
        $data = $request->all();
        if (isset($request->hkid_image)) {
            $hkid_image = $e->hkid_image;
            $file_list = $this->fileUpload($request->hkid_image, "hkid_image", $e->uuid);
            if (!empty($hkid_image)) {
                array_merge($hkid_image, $file_list);
            } else {
                $hkid_image = $file_list;
            }
            $data['hkid_image'] = serialize($hkid_image);
        }
        if (isset($request->bank_card_image)) {
            $bank_card_image = $e->bank_card_image;
            $file_list = $this->fileUpload($request->bank_card_image, "bank_card_image", $e->uuid);
            if (!empty($bank_card_image)) {
                array_merge($bank_card_image, $file_list);
            } else {
                $bank_card_image = $file_list;
            }
            $data['bank_card_image'] = serialize($bank_card_image);
        }
        if (isset($request->support_documents)) {
            $support_documents = $e->support_documents;
            $file_list = $this->fileUpload($request->support_documents, "support_documents", $e->uuid);
            if (!empty($support_documents)) {
                array_merge($support_documents, $file_list);
            } else {
                $support_documents = $file_list;
            }
            $data['support_documents'] = serialize($support_documents);
        }

        if (isset($request->file_name)) {
            //TODO if file_path no same with storage path, make it is network attack
            $storage_path = 'uploads/eh/' . Auth::user()->profile->organization->name_slug . '/employee/' . $uuid . '/avatar/';
            $avatar = [
                'file_name' => $request->file_name,
                'file_source_name' => $request->file_source_name,
                'file_path' => $storage_path,
                'file_size' => $request->file_size,
                'file_type' => 'image',
                'file_extension' => 'jpg',
            ];
            $data['avatar_file'] = serialize($avatar);
        }

        $this->makeLog($e->uuid, 'employee', config('constants.EMPLOYEE_LOG.EVENT.UPDATED'), $data, Auth::user()->id, $data['edit_reason']);

        if ($data['probation_end_date'] < date('Y-m-d')) {
            $data['type'] = config('constants.EMPLOYEE.TYPE.REGULAR');
        } else {
            $data['type'] = config('constants.EMPLOYEE.TYPE.TRIAL');
        }

        $annual_leave = $data['annual_leave'];
        if ($e->annual_leave != $annual_leave) {
            $leave_type = LeaveType::where('type', config('constants.LEAVE_TYPE.TYPE.ANNUAL_LEAVE'))->get();
            foreach ($leave_type as $lt) {
                // TODO 更新年假後，保留已使用大假，只更新最大值。不創建新到balance紀錄
//                    $this->setEmployeeBalance($lt,$e->join_date,$e->uuid->toString());
            }
        }

        $e->update($data);

        if (isset($request->is_active)) {
            $u = User::findOrFail($e->user_id);
            $u->is_active = $this->checkbox2boolean($data, 'is_active');
            $u->save();
        }

        // TODO, when update 年假 or department, designation, employee type.
        //    檢查 leave balance and update

        session()->flash('message', $msg_update_success);
        return redirect()->route("eh.employee.show", $e->uuid);

    }

    /**
     * Delete the input value inputted from create page
     *
     * @param Employee $e
     * @return RedirectResponse
     */
    public function destroy($uuid) {
        $msg_destroy_success = "Employee deleted.";

        $e = Employee::findOrFail($uuid);
        $this->makeLog($uuid, 'employee', config('constants.EMPLOYEE_LOG.EVENT.DELETED'));
        $e->delete();
        session()->flash('message', $msg_destroy_success);
        return redirect()->route("eh.employee.index");
    }

    /**
     * @param $uuid
     * @return RedirectResponse
     */
    public function resetPassword($uuid) {
        $msg_update_success = "Employee password updated.";

        $e = Employee::findOrFail($uuid);
        $user_id = $e->user->id;
        $this->checkUser($user_id);
        $u = User::findOrFail($user_id);

        $password = Str::random('8');
        $u->password = Hash::make($password);
        $u->save();

        // Send email to employee
        $email_data = [
            'source_email' => 'info@clixells.com', // TODO change to company config
            'recipient_email' => [],
            'data' => [
                'first_name' => $e->first_name,
                'last_name' => $e->last_name,
                'password' => $password,
            ]
        ];
        array_push($email_data['recipient_email'], $u->email);
        $this->sendEmail(EmailTemplateType::MSG_EP_0002, $email_data);

        session()->flash('alert-success', "Password reset success. New password sent to employee email. [DEBUG] password: " . $password);
        return redirect()->route("eh.employee.show", $uuid);
    }

    /**
     * @param $id
     */
    public function checkUser($id) {
        if (User::role(config('constants.ROLE.USER'))->where('id', $id)->whereHas('profile', function ($query) {
                return $query->whereHas('organization', function ($query) {
                    return $query->where('organization_id', Auth::user()->profile->organization->id);
                });
            })->count() != 1) {
            abort(404);
        }
    }

    /**
     * @param $files
     * @param $field
     * @param $e_uuid
     * @return array
     */
    public function fileUpload($files, $field, $e_uuid): array {
        $file_data = [];
        if (!is_null($files) && sizeof($files) > 0) {
            foreach ($files as $file) {
                $storage_path = 'uploads/eh/' . Auth::user()->profile->organization->name_slug . '/employee/' . $e_uuid . '/' . $field . '/';

                $originName = $file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;
                $size = $file->getSize();
                $file->move(storage_path('app/private/' . $storage_path), $fileName);

                $file_name = $fileName;
                $file_source_name = $originName;
                $file_path = $storage_path;

                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        $file_type = 'image';
                        break;
                    case 'html':
                    case 'htm':
                        $file_type = 'html';
                        break;
                    case 'txt':
                        $file_type = 'text';
                        break;
                    case 'doc':
                    case 'docx':
                    case 'xls':
                    case 'xlsx':
                    case 'ppt':
                    case 'pptx':
                        $file_type = 'office';
                        break;
                    case 'tif':
                    case 'ai':
                    case 'eps':
                        $file_type = 'gdocs';
                        break;
                    case 'pdf':
                        $file_type = 'pdf';
                        break;
                    case 'avi':
                    case 'mpg':
                    case 'mkv':
                    case 'mov':
                    case 'mp4':
                    case '3gp':
                    case 'webm':
                    case 'wmv':
                        $file_type = 'video';
                        break;
                    case 'mp3':
                    case 'wav':
                        $file_type = 'audio';
                        break;
                    default:
                        $file_type = 'other';
                        break;
                }

                $detail = [
                    'file_name' => $file_name,
                    'file_source_name' => $file_source_name,
                    'file_path' => $file_path,
                    'file_size' => $size,
                    'file_type' => $file_type,
                    'file_extension' => $extension,
                ];
                array_push($file_data, $detail);
            }
        }
        return $file_data;
    }

    public function fileDelete(Request $request, $uuid) {
        $msg_destroy_success = "File deleted.";

        $p = urldecode($request->p); // file path (app/files)
        $fn = urldecode($request->fn); // file name
        $field = $request->field; // field
        $key = $request->key; // field

        $e = Employee::find($uuid);
        $files = $e->{$field};
        if ($files[$key]['file_path'] . $files[$key]['file_name'] == $p && $files[$key]['file_source_name'] == $fn) {
            unset($files[$key]);
            $e->{$field} = serialize($files);
            $e->save();
            return response()->json(['message' => $msg_destroy_success, 'code' => 200]);
        }
        return response()->json(['message' => 'Server Fail', 'code' => 500], 500);
    }

    /**
     * Show the clone page for the selected record.
     *
     * @param uuid $uuid
     *
     * @return RedirectResponse
     * @return View
     */
    public function job_application($uuid) {
        $this->mode['isModeClone'] = true;

        $e = JobApplication::findOrFail($uuid);
        $genders = Gender::where('is_active', true)->get();
        $martial_status = MartialStatus::where('is_active', true)->get();
        $nationalities = Nationality::where('is_active', true)->get();
        $titles = Title::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();
        $designations = Designation::where('is_active', true)->get();
        $relationships = Relationship::where('is_active', true)->get();
        $employee_types = EmployeeType::where('is_active', true)->get();
        $banks = Bank::where('is_active', true)->get();
        $grades = Grade::where('is_active', true)->get();
        $highest_educations = HighestEducation::where('is_active', true)->get();
        $employees = Employee::all();
        return view("eh.employee.detail", compact('e', 'highest_educations', 'genders', 'grades', 'banks', 'martial_status', 'nationalities', 'titles', 'departments', 'designations', 'relationships', 'employee_types', 'employees'))->with('mode', $this->mode);
    }


    public function uploadCropperImage(Request $request, $e_uuid) {
        // validate request data

        // request is base64 image data.
        // TODO https://github.com/crazybooot/base64-validation
        $this->validate($request, [
            'image' => 'required',
            'image_name' => 'required|string',
        ]);

        if ($e_uuid == 'create') {
            $e_uuid = 'temp';
        }

        $storage_path = 'uploads/eh/' . Auth::user()->profile->organization->name_slug . '/employee/' . $e_uuid . '/avatar/';
        $folderPath = storage_path('app/private/' . $storage_path);

        $image_parts = explode(";base64,", $request->image);
        $image_type_aux = explode("image/", $image_parts[0]);

        $image_base64 = base64_decode($image_parts[1]);
        $filename = uniqid() . '.jpg';
        $file = $folderPath . $filename;

        // create file and folder
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }
        $size = file_put_contents($file, $image_base64);

        $file_name = $filename;
        $file_source_name = 'avatar.jpg';
        $file_path = $storage_path;

        $detail = [
            'file_name' => $file_name,
            'file_source_name' => $file_source_name,
            'file_path' => $file_path,
            'file_size' => $size,
            'file_type' => 'image',
            'file_extension' => 'jpg',
        ];

        $response = [
            'data' => $detail,
            'message' => 'success',
        ];
        return response()->json($response);
    }

    public function setEmployeeBalance($leave_type, $employee_join_date, $employee_uuid) {

        //獲取員工
        $employees = [];
        $employees += [$employee_uuid => $employee_join_date];

        // ------------------------

        //判斷請假類別

        // 如果是一般假期
        if ($leave_type->type == config('constants.LEAVE_TYPE.TYPE.GENERAL')) {

            //預設起始請假天數
            $default_max_balance = $leave_type->settings['default_max_balance'];
            // 每多少年增加一次
            $cycle_add_each = $leave_type->settings['cycle_add_each'];
            // 每次增加多少假期
            $cycle_add_day = $leave_type->settings['cycle_add_day'];
            // 最多增加到幾天
            $cycle_add_max = $leave_type->settings['cycle_add_max'];
            // 可以帶多少天到下一年
            $cycle_keep_balance = $leave_type->settings['cycle_keep_balance'];

            // 沒有結算
            if ($leave_type->settings['billing_cycle'] == config('constants.LEAVE_TYPE.BILLING_CYCLE.NOT_APPLICABLE')) {

                // 直接套用預設最大假期
                foreach ($employees as $uuid => $join_date) {
                    $balance = LeaveBalance::firstOrCreate([
                        'leave_type_id' => $leave_type->id,
                        'employee_uuid' => $uuid,
                    ], [
                        'max_balance' => $leave_type->settings['default_max_balance']
                    ]);
                }
            } // 按年結算
            elseif ($leave_type->settings['billing_cycle'] == config('constants.LEAVE_TYPE.BILLING_CYCLE.YEAR')) {

                // 判斷結算起始日類型
                // 按照員工入職日
                if ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.JOIN_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即year +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = new DateTime($join_date);
                            $now = new DateTime();

                            $diff = $now->diff($start);
                            $times = $diff->y;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' year', strtotime($join_date)));

                            $max = $default_max_balance + $times * $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }


                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $max,
                                'reset_date' => $reset_date
                            ]);
                        }
                    } // 按照自然日計算，即下一年的一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('1st January Next Year');
                        $reset_date = $endDate->format('Y-m-d');

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            // cal employee max balance
                            $start = new DateTime($join_date);
                            $now = new DateTime($reset_date);

                            $diff = $now->diff($start);
                            $times = $diff->y;

                            $max = $default_max_balance + $times * $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $max,
                                'reset_date' => $reset_date
                            ]);
                        }
                    }

                } // 按照創建日開始計算
                elseif ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.CREATE_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即year +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = new DateTime($join_date);
                            $now = new DateTime();

                            $diff = $now->diff($start);
                            $times = $diff->y;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' year', strtotime($join_date)));

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $default_max_balance,
                                'reset_date' => $reset_date
                            ]);
                        }
                    } // 按照自然日計算，即下一年的一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('1st January Next Year');
                        $reset_date = $endDate->format('Y-m-d');

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $default_max_balance,
                                'reset_date' => $reset_date
                            ]);
                        }
                    }

                }
            } // 按月結算
            elseif ($leave_type->settings['billing_cycle'] == config('constants.LEAVE_TYPE.BILLING_CYCLE.MONTH')) {
                // 判斷結算起始日類型
                // 按照員工入職日
                if ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.JOIN_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即year +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = $join_date;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $times = $diff;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' month', strtotime($join_date)));

                            $max = $default_max_balance + $times * $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }


                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $max,
                                'reset_date' => $reset_date
                            ]);

                        }
                    } // 按照自然日計算，即下一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('first day of next month');
                        $reset_date = $endDate->format('Y-m-d');

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            // cal employee max balance
                            $start = $join_date;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $times = $diff;

                            $max = $default_max_balance + $times * $cycle_keep_balance;
                            if ($times > 0) {
                                for ($i = 0; $i < $times; $i += $cycle_add_each) {
                                    if ($max + $cycle_add_day < $cycle_add_max) {
                                        $max += $cycle_add_day;
                                    } else {
                                        $max = $cycle_add_max;
                                    }
                                }
                            } else {
                                $max = $default_max_balance;
                            }

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $max,
                                'reset_date' => $reset_date
                            ]);

                        }
                    }

                } // 按照創建日開始計算
                elseif ($leave_type->settings['cycle_start_day'] == config('constants.LEAVE_TYPE.CYCLE_START_DAY.CREATE_DAY')) {

                    // 判斷下一結算日類型
                    // 按照員工入職日計算，即month +1
                    if ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.JOIN_DAY')) {
                        foreach ($employees as $uuid => $join_date) {
                            // cal employee max balance
                            $start = $join_date;
                            $now = date('Y-m-d');

                            $ts_start = strtotime($start);
                            $ts_now = strtotime($now);

                            $start_year = date('Y', $ts_start);
                            $now_year = date('Y', $ts_now);

                            $start_month = date('m', $ts_start);
                            $now_month = date('m', $ts_now);

                            $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                            $times = $diff;

                            $reset_date = date('Y-m-d', strtotime('+' . ($times + 1) . ' year', strtotime($join_date)));

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $default_max_balance,
                                'reset_date' => $reset_date
                            ]);

                        }
                    } // 按照自然日計算，即下一年的一月一號
                    elseif ($leave_type->settings['cycle_cal_day'] == config('constants.LEAVE_TYPE.CYCLE_CAL_DAY.NATURE_DAY')) {
                        $endDate = new DateTime('first day of next month');
                        $reset_date = $endDate->format('Y-m-d');

                        // create employee balance
                        foreach ($employees as $uuid => $join_date) {

                            $balance = LeaveBalance::firstOrCreate([
                                'leave_type_id' => $leave_type->id,
                                'employee_uuid' => $uuid,
                            ], [
                                'max_balance' => $default_max_balance,
                                'reset_date' => $reset_date
                            ]);

                        }
                    }

                }
            }
        } // 年假
        elseif ($leave_type->type == config('constants.LEAVE_TYPE.TYPE.ANNUAL_LEAVE')) {

            //預設起始請假天數
            $default_max_balance = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.DEFAULT_MAX_BALANCE');
            // 每多少年增加一次
            $cycle_add_each = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_EACH');
            // 每次增加多少假期
            $cycle_add_day = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_DAY');
            // 最多增加到幾天
            $cycle_add_max = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_MAX');
            // 可以帶多少天到下一年
            $cycle_keep_balance = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_KEEP_BALANCE');
            // 跳過頭到多少年的累加
            $cycle_add_skip = config('constants.LEAVE_TYPE.ANNUAL_LEAVE.CYCLE_ADD_SKIP');

            foreach ($employees as $uuid => $join_date) {
                $join_datetime = new DateTime($join_date);
                $join_date_month = $join_datetime->format('m');

                $now = new DateTime();

                $diff = $now->diff($join_datetime);
                $times = $diff->y;

                $endDate = new DateTime('1st January Next Year');
                $reset_date = $endDate->format('Y-m-d');

                if ($times == 0) {
                    if ($join_date_month > 0 && $join_date_month <= 6) {
                        $times += 1;
                    } else {
                        $balance = LeaveBalance::firstOrCreate([
                            'leave_type_id' => $leave_type->id,
                            'employee_uuid' => $uuid,
                        ], [
                            'max_balance' => 0,
                            'reset_date' => $reset_date
                        ]);
                        continue;
                    }
                } elseif ($times == 1) {
                    if ($join_date_month > 6 && $join_date_month <= 12) {
                        $times -= 1;
                    }
                }

                $default_max_balance = (int)Employee::find($uuid)->annual_leave;
                $cycle_add_max = $default_max_balance + 7;

                if ($times != 0) {
                    $max = $default_max_balance + $times * $cycle_keep_balance;

                    $skip = $cycle_add_skip;
                    for ($i = 0; $i < $times; $i += $cycle_add_each) {
                        if ($skip > 0) {
                            $skip--;
                        } else {
                            if ($max + $cycle_add_day < $cycle_add_max) {
                                $max += $cycle_add_day;
                            } else {
                                $max = $cycle_add_max;
                                break;
                            }
                        }
                    }
                } else {
                    $max = 0;
                }

                $balance = LeaveBalance::firstOrCreate([
                    'leave_type_id' => $leave_type->id,
                    'employee_uuid' => $uuid,
                ], [
                    'max_balance' => $max,
                    'reset_date' => $reset_date
                ]);

            }
        }// 有薪病假
        elseif ($leave_type->type == config('constants.LEAVE_TYPE.TYPE.PAID_SICK_LEAVE')) {

            //預設起始請假天數
            $default_max_balance = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.DEFAULT_MAX_BALANCE');
            // 每多少月增加一次
            $cycle_add_each = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_EACH');
            // 每次增加多少假期
            $cycle_add_day = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_DAY');
            // 最多增加到幾天
            $cycle_add_max = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_MAX');
            // 可以帶多少天到下一個月
            $cycle_keep_balance = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_KEEP_BALANCE');
            // 跳過頭到多少月的累加
            $cycle_add_skip = config('constants.LEAVE_TYPE.PAID_SICK_LEAVE.CYCLE_ADD_SKIP');

            foreach ($employees as $uuid => $join_date) {

                // cal employee max balance
                $start = $join_date;
                $now = date('Y-m-d');

                $ts_start = strtotime($start);
                $ts_now = strtotime($now);

                $start_year = date('Y', $ts_start);
                $now_year = date('Y', $ts_now);

                $start_month = date('m', $ts_start);
                $now_month = date('m', $ts_now);

                $diff = (($now_year - $start_year) * 12) + ($now_month - $start_month);
                $times = $diff;

                $max = $default_max_balance;
                if ($times > 12) {
                    $max = 12 * $cycle_add_day;
                    $times -= 12;
                    $max += $times * $cycle_add_day * 2;
                } else {
                    $max = $times * $cycle_add_day;
                }

                if ($max > $cycle_add_max) {
                    $max = $cycle_add_max;
                }

                $balance = LeaveBalance::firstOrCreate([
                    'leave_type_id' => $leave_type->id,
                    'employee_uuid' => $uuid,
                ], [
                    'max_balance' => $max,
                    'reset_date' => null
                ]);
            }
        }
    }
}
