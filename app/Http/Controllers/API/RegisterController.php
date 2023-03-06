<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;

class RegisterController extends Controller
{
    private $RESPONSE = array();

    
    function __construct()
    {
    }

    function register(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'name' => 'required|string|min:6|max:30',
            'email' => 'required|email|min:10|max:50|unique:users,email',
            'username' => 'required|string|min:6|max:15|unique:users,username',
            'password' => 'required|string|min:6|max:15|confirmed'
        ]);
        
        if ($validator->fails()) {
            $this->RESPONSE['code'] = 400;
            $this->RESPONSE['message'] = $validator->errors();
        }
        else {
            $inputs = $request->input();
            $inputs['password'] = Hash::make($inputs['password']);
            $user = User::create($inputs);

            $this->RESPONSE['code'] = 200;
            $this->RESPONSE['message'] = 'OK';
            $this->RESPONSE['count'] = 1;
            $this->RESPONSE['data'] = [
                'token' => $user->createToken(env('app.token_name'))->accessToken,
                'user' => array(
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                ),
            ];
        }

        return response()->json($this->RESPONSE);
    }
}
