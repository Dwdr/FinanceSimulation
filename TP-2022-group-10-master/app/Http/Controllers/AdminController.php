<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth\UserProfile;
use App\Models\EH\Employee;
use App\Models\Stock\Holding;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
     public function index(Request $request){

    //inner join
     $usernameAndCredits = DB::table('sys_user_profiles')
    ->join('eh_employees', 'sys_user_profiles.user_id', '=', 'eh_employees.user_id')
    ->select('eh_employees.first_name', 'eh_employees.user_id','sys_user_profiles.credits')
    ->get();
        return view("eh.admin.index" , compact("usernameAndCredits"));
    }


     public function destroy(Request $request, $user_id){
        // Reset the user's credits to 100,000 in the sys_user_profiles table.
        DB::table('sys_user_profiles')
        ->where('user_id', $user_id)
        ->update(['credits' => '100000']);

        // Delete all holdings associated with the user from the holdings table.
        DB::table('holdings')
        ->where('user_id', $user_id)
        ->delete();
    // Redirect the user to the admin dashboard with a success message.
    return redirect()->route('eh.admin.index')->with('success', 'Reset successful!');
    }
}
