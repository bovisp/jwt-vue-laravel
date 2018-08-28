<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ResetPassword;
use App\Classes\GeneratePasswordResetToken;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\ForgotPasswordFormRequest;

class PasswordResetController extends Controller
{
    public function email(ForgotPasswordFormRequest $request)
    {
    	$sendEmailWithToken = new GeneratePasswordResetToken($request->email);

    	$sendEmailWithToken->send();

    	return response()->json([
    		'msg' => 'Email sent!'
    	]);
    }

    public function reset($token, ResetPasswordFormRequest $request)
    {
    	$resetPassword = new ResetPassword($token, $request);

    	$errors = $resetPassword->hasErrors();

    	if (count($errors)) {
    		return response([
    			'errors' => [
    				'invalid' => $errors[0]
    			]
    		], 422);
    	}

    	$resetPassword->update();

    	return response()->json([
    		'success' => 'Password updated'
    	]);
    }
}
