<?php

namespace App\Classes;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class GeneratePasswordResetToken
{
	protected $email;

	public function __construct($email)
	{
		$this->email = $email;
	}

	public function send()
	{
		$user = $this->getUserFromEmail();

		$hash = $this->createPasswordResetHash($user);

		$this->sendEmail($hash, $user);

		return;
	}

	protected function getUserFromEmail()
	{
		return User::whereEmail($this->email)->first();
	}

	protected function createPasswordResetHash(User $user)
	{
		$hash = hash_hmac('sha256', Str::random(40), env('APP_KEY'));

		$this->setHash($hash, $user);

    	return $hash;
	}

	protected function setHash($hash, User $user)
	{
		DB::table('password_resets')->insert([
    		'email' => $user->email,
    		'token' => $hash,
    		'created_at' => Carbon::now()
    	]);

    	return;
	}

	protected function sendEmail($hash, User $user)
	{
		$title = 'Reset your password';

    	$content = 'Click on the link below to reset your password';

    	$link = "http://localhost:8080/reset/" . $hash;

    	Mail::send('email.reset', compact('title', 'content', 'link'), function($message) use ($user) {
    		$message->from('gymlinks@hotmail.com', 'Paul Bovis');
    		$message->to($user->email);
    	});

    	return;
	}
}