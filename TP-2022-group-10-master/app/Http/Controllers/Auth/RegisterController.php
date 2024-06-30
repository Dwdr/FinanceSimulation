<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\EH\Employee;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
     public function index() {
        return view('layouts.login_v18.register');
     }


    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:laravel_user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      /**
       *  TODO email confirm
       */

      $u = User::create([
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
      ]);

      // role is individual-user
      $u->assignRole(config('constants.ROLE.INDIVIDUAL_USER'));
      UserProfile::create([
        'user_id' => $u->id,
        'name' => $data['name'],
        'status' => true,
      ]);
        return $u;
    }

    protected function registered(Request $request)
    {
      session()->flash('status', "Registration is successful, please log in.");
      return redirect('auth.login');
    }


    public function registerNewUser(Request $request){
      $user = new User;
      $user->email = request('email');
      $user->password = Hash::make(request('password'));
      $user->is_active = true;
      $user->status = config('constants.SYS-USER-STATUS.NORMAL');
      $user->assignRole(config('constants.ROLE.ADMIN'));
      $user->save();


      $profile = UserProfile::create([
            'user_id' => $user->id,
            'credits' => 100000, //USD
            'historical_sim_credits' => 100000, //USD
      ]);

      $employee = Employee::create([
            'uuid' => Str::uuid(),
            'user_id' => $user->id,
            // 'title_id' => 1,
            'first_name' => request('firstName'),
            'last_name' => request('lastName'),
             'email' => $user->email,
        ]);
      return redirect()->route('auth.login')->with('message','success!');
       }        

}
