<?php

namespace App\Classes;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ResetPassword
{
	protected $token;

	protected $request;

	protected $errors = [];

	protected $tokenRecord;

	public function __construct($token, $request)
	{
		$this->token = $token;
		$this->request = $request;

		$this->tokenRecord = $this->getTokenRecord();
	}

	public function hasErrors()
	{
		$this->tokenInvalid();
		$this->tokenExpired();

		return $this->errors;
	}

	public function update()
	{
		$user = $this->getUserFromEmail();

		$this->saveNewPassword($user);

		$this->deleteToken();
	}

	protected function getUserFromEmail()
	{
		return User::whereEmail($this->tokenRecord->email);
	}

	protected function saveNewPassword($user)
	{
		$user->update([
    		'password' => bcrypt($this->request->password)
    	]);
	}

	protected function deleteToken()
	{
		DB::table('password_resets')->where('token', $this->token)->delete();
	}

	protected function getTokenRecord()
	{
		return DB::table('password_resets')->where('token', $this->token)->first();
	}

	protected function tokenInvalid()
	{
		if (collect($this->tokenRecord)->count() === 0) {
			$this->errors[] = 'That is an invalid reset code.';
		}
	}

	protected function tokenExpired()
	{
		if (count($this->errors) === 0) {
			$isExpired = Carbon::parse($this->tokenRecord->created_at)
				->addSeconds(3600)
				->isPast();

			if ($isExpired) {
				$this->errors[] = 'That is an expired reset code.';
			}
		}
	}
}