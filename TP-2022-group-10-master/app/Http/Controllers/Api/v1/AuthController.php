<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthController extends Controller
{
  protected $clientId;
  protected $clientSecret;

  public function __construct()
  {
      /*
    $this->middleware('auth:api')->except('login', 'register', 'refresh');
    $client = Cache::remember('password_client', 60 * 60, function () {
      return \DB::table('oauth_clients')->where('provider', "users")->first();
    });
    $this->clientId = $client->id;
    $this->clientSecret = $client->secret;
      */
  }

  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255'],
      'password' => ['required', 'string', 'min:8'],
    ]);
  }

  protected function create(array $data)
  {
    return User::forceCreate([
      'name' => $data['first_name'],
      'email' => $data['email'],
      'password' => password_hash($data['password'], PASSWORD_DEFAULT),
      'status' => 1,
    ]);
  }

  public function register()
  {
    $this->validator(request()->all())->validate();
    $this->create(request()->all());
    return $this->getToken();
  }

  public function login(Request $request)
  {

    if (empty($request['email'])) {
      return response(['message' => 'You input wrong email, please try again.'], 400);
    } else if (empty($request['password'])) {
      return response(['message' => 'You input wrong password, please try again.'], 400);
    }


    if ($user = User::where('email', request('email'))->first()) {
      if (!password_verify(request('password'), $user->password)) {
        return response()->json(['error' => 'Email or Password Error!'],
          412);
      }
    } else {
      return response()->json(['error' => 'Email or Password Error!'],
        412);
    }


    return $this->getToken();
//        return 'pass';
  }

  public
  function logout()
  {
    $tokenModel = auth()->user()->token();
    $tokenModel->update([
      'revoked' => 1,
    ]);

    \DB::table('oauth_refresh_tokens')
      ->where(['access_token_id' => $tokenModel->id])->update([
        'revoked' => 1,
      ]);

    return ['message' => 'Successfully logged out'];
  }

  public
  function refresh()
  {
    $data = (new Client())->post(asset('api/v1/auth/oauth/token'), [
      'form_params' => [
        'grant_type' => 'refresh_token',
        'refresh_token' => request('refresh_token'),
        'client_id' => $this->clientId,
        'client_secret' => $this->clientSecret,
        'scope' => '*',
      ],
    ]);
    $response = Response::make($data->getBody(), 200);
    $response->header('Content-Type', 'application/json');
    return $response;
  }

  private
  function getToken()
  {
    $data = (new Client())->post(asset('api/v1/auth/oauth/token'), [
      'form_params' => [
        'grant_type' => 'password',
        'username' => request('email'),
        'password' => request('password'),
        'client_id' => $this->clientId,
        'client_secret' => $this->clientSecret,
        'scope' => '*',
      ],
    ]);
    $response = Response::make($data->getBody(), 200);
    $response->header('Content-Type', 'application/json');
    return $response;
  }
}
