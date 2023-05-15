<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $RESPONSE = [
        'code' => 500,
        'message' => 'Server Error',
        'count' => 0,
        'data' => array(),
    ];


    function __construct()
    {
    }

    function login(Request $request)
    {
        // dd($request->input()); die();
        $validator = Validator::make($request->input(), [
            'email' => 'required|email|min:10|max:50',
            'password' => 'required|string|min:6|max:15'
        ]);

        if ($validator->fails()) {
            $this->RESPONSE['code'] = 403;
            $this->RESPONSE['message'] = 'Email or Password is incorrect.';
        }
        else {
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                $user = Auth::user();
    
                $this->RESPONSE['code'] = 200;
                $this->RESPONSE['message'] = 'OK';
                $this->RESPONSE['count'] = 1;
                $this->RESPONSE['data']['user'] = $user;
                $this->RESPONSE['data']['token'] = $user->createToken(env('app.token_name'))->accessToken;
            }
            else {
                $this->RESPONSE['code'] = 404;
                $this->RESPONSE['message'] = 'Account does not exist.';
            }
        }
        
        return response()->json($this->RESPONSE);
    }
}
