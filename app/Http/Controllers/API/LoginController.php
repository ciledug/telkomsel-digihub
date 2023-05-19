<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    function __construct()
    {
    }

    function login(Request $request)
    {
        // dd($request->input()); die();

        $response = [
            'code' => 500,
            'message' => 'Server Error',
            'count' => 0,
            'data' => array(),
        ];

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
                'password' => $request->password,
                'status' => 1
            ])) {
                $user = Auth::user();
    
                $response['code'] = 200;
                $response['message'] = 'OK';
                $response['count'] = 1;
                $response['data']['user'] = $user;
                $response['data']['token'] = $user->createToken(env('app.token_name'))->accessToken;
            }
            else {
                $response['code'] = 404;
                $response['message'] = 'Account does not exist.';
            }
        }
        
        return response()->json($response);
    }
}
