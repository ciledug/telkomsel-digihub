<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class UserController extends Controller
{
    private $RESPONSE = [
        'code' => 500,
        'message' => 'Server Error',
        'count' => 0,
        'data' => array()
    ];

    
    function __construct() {
    }

    function show()
    {
        $this->RESPONSE['code'] = 200;
        $this->RESPONSE['message'] = 'OK';
        $this->RESPONSE['count'] = 1;
        $this->RESPONSE['data']['user'] = Auth::user();
        return response()->json($this->RESPONSE);
    }
}
