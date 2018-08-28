<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
	{
		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'password' => bcrypt($request->password)
		]);

	    return response([
	        'status' => 'success',
	        'data' => $user
	       ], 200);
	}

	public function login(LoginFormRequest $request)
	{
		$credentials = $request->only('email', 'password');

	    if (!$token = JWTAuth::attempt($credentials)) {
	            return response()->json([
	                'error' => 'invalid.credentials',
	                'msg' => 'Invalid Credentials.'
	            ], 400);
	    }

	    return response([
	            'status' => 'success'
	        ])
	        ->header('Authorization', $token);
	}

	public function user(Request $request)
	{
	    return response([
            'status' => 'success',
            'data' => new UserResource(auth()->user())
        ]);
	}

	public function refresh()
	{
	    return response([
	            'status' => 'success'
	        ]);
	}

	public function logout()
	{
	    JWTAuth::invalidate();
	    
	    return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
	}
}
