<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

use App\Models\UserLog;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'email' => 'required|string|min:10|max:50',
            'password' => 'required|string|min:6|max:15'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $fieldType = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (auth()->attempt(array(
            $fieldType => $request->email,
            'password' => $request->password
        ))) {
            UserLog::create([
                'user_id' => Auth::user()->id,
                'last_login' => Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s'),
                'last_ip_address' => $request->ip(),
            ]);
            
            return redirect()->route('dashboard');
        }
        else {
            $validator->errors()->add('login_invalid', 'Email Address or Password is incorrect!');
            return back()->withErrors($validator)->withInput();
        }
    }
}
