<?php

class UserSeeder extends DatabaseSeeder
{
	public function run()
	{
		$users = [
		[
		'username' => 'taroliu', 
		'password' => Hash::make('123456'),
		'email' => 'taroliu0907@gmail.com'
		]
		];

		foreach ($users as $user)
		{
			User::create($user);
		}
	}
}