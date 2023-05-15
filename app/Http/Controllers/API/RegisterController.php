<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Models\UserProfile;

class RegisterController extends Controller
{

    function __construct()
    {
    }

    function register(Request $request)
    {
        $response = array(
            'code' => 500,
            'count' => 0,
            'message' => 'Server error',
            'data' => array(),
        );

        $validator = $this->validator($request->input());
        
        if ($validator->fails()) {
            $response['data']['errors'] = $validator->errors();
            return response()->json($response, 200);
        }
        
        $user = $this->create($request->input());

        if ($user) {
            $response['code'] = 200;
            $response['count'] = 1;
            $response['message'] = 'OK';
            $response['data']['user'] = [
                'user_id' => $user->id,
            ];
        }

        return response()->json($response, 200);
    }

    protected function create(array $data)
    {
        // dd($data);
        $user = User::create([
            'name' => $data['register_company_name'],
            'email' => $data['register_company_email'],
            'username' => $data['register_company_email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($user) {
            $userProfile = UserProfile::create([
                'user_id' => $user->id,
                'client_id' => $data['register_client_id'],
                'company' => $data['register_company_name'],
                'legal_entity' => $data['register_legal_entity'],
                'business_field' => $data['register_business_field'],
                'address' => $data['register_address'],
                'company_site' => $data['register_company_website'],
                'contact_person' => $data['register_full_name'],
                'cp_position' => $data['register_position'],
                'cp_email' => $data['register_email'],
                'cp_phone' => $data['register_phone'],
            ]);
        }

        return $user;
    }

    private function validator(array $data)
    {
        // dd($data);
        $validator = Validator::make($data, [
            'register_client_id' => 'required|string|min:4|max:20|unique:user_profiles,client_id',
            'register_company_name' => 'required|string|min:5|max:50',
            'register_company_email' => 'required|email|min:5|max:50|unique:users,email',
            'register_full_name' => 'required|string|min:5|max:50',
            'register_email' => 'required|email|min:10|max:50|unique:user_profiles,cp_email',
            'register_phone' => 'required|numeric|min:810000000|max:999999999999999',
            'register_position' => 'required|numeric|min:1|max:15',
            'password' => 'required|string|min:6|max:15|confirmed',
            'password_confirmation' => 'required|string|min:6|max:15',
            
            'register_legal_entity' => 'nullable|numeric|min:1|max:15',
            'register_business_field' => 'nullable|numeric|min:1|max:15',
            'register_address' => 'nullable|string|min:10|max:255',
            'register_company_website' => 'nullable|string|min:7|max:50',
        ]);
        return $validator;
    }
}
