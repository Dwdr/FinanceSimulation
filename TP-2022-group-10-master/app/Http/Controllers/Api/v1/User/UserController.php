<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Api\v1\ApiController;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends ApiController {

    public function profile(Request $request) {
        try {
            $user = User::with('profile','organization')->find(Auth::user()->id);
            return parent::sendResponse('data', $user, 'User profile');
        } catch (\Exception $e) {
            return parent::sendError($e->getMessage());
        }
    }

}
