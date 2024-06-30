<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Auth\UserOAuth;
use App\Models\Auth\UserProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller {

  public function redirect($service) {
    return Socialite::driver($service)->redirect();
  }

  public function callback($service) {
    $user = '';
    switch ($service) {
      case 'apple':     // test: Apple Developer Program Enrollment could not be completed.
      case 'facebook':  // test: facebook api need https request
      case 'google':    // test: pass
      case 'github':    // test: pass
      case 'linkedin':  // test: pass
      case 'twitter':   // test: pass
        $user = Socialite::driver($service)->user();
        break;
    }

    $u = UserOAuth::where('provider', $service)->where('provider_id', $user->id)->first();
    if(!$u) {

      // TODO Jimmy: if new OAuth have same email with database, system pass to same user?
      $u = User::where('email', $user->email)->first();
      if($u) {
        if(UserOAuth::where('provider', $service)->where('user_id', $u->id)->first()) {
          session()->flash('alert-warning', "The account has been bound.");
          return redirect()->route('login');
        }
      }

      if(!$u && !Auth::check()) {
        // create user account
        $u = User::create([
          'email' => $user->email,
          'password' => 'OAuth_Login_' . Str::random(12),
        ]);

        // role is individual-user
        $u->assignRole(config('constants.ROLE.INDIVIDUAL_USER'));

        // create user profile
        UserProfile::create([
          'user_id' => $u->id,
          'name' => $user->name,
          //'avatar_id' => $user->avatar, // todo save image to storage
          'status' => true,
        ]);
      }

      if(!Auth::check()) {
        UserOAuth::create([
          'user_id' => $u->id,
          'provider' => $service,
          'provider_id' => $user->id,
          'token' => $user->token,
        ]);
      } else {
        UserOAuth::create([
          'user_id' => Auth::user()->id,
          'provider' => $service,
          'provider_id' => $user->id,
          'token' => $user->token,
        ]);
      }

    } else {
      $u = $u->user;
    }


    session()->flash('alert-success', "Bind the " . Str::ucfirst($service) . " account successfully.");
    if(!Auth::check()) {
      Auth::login($u);
      return redirect(RouteServiceProvider::HOME);
    } else {
      return redirect()->route('profile.index');
    }

  }

  public function disconnect($service) {
    // todo route change to DELETE method

    if(UserOAuth::where('user_id', Auth::user()->id)->count() == 1) {
      if(Str::substr(Auth::user()->password, 0, 11) == 'OAuth_Login') {
        session()->flash('alert-warning', "Please set the login password before unbinding the account.");
        return redirect()->route('profile.index');
      }
    }

    $oauth = UserOAuth::where('user_id', Auth::user()->id)->where('provider', $service)->first();
    if($oauth != null) {
      $oauth->delete();
    }

    session()->flash('alert-success', "Successfully unbind the " . Str::ucfirst($service) . " account.");
    return redirect()->route('profile.index');
  }
}
