<?php

use Illuminate\Support\MessageBag;

class UserController extends Controller
{
	public function loginAction()
	{
		$errors = new MessageBag();

		if($old = Input::old("errors"))
		{
			$errors = $old;
		}
		$data = [
		"errors" => $errors
		];

		if(Input::server("REQUEST_METHOD")=="POST")
		{
			$validator = Validator::make(Input::all(),["username" => "required", "password" => "required"]);

			if($validator->passes())
			{
				$credentials =[
				"username" => Input::get("username"),
				"password" => Input::get("password")
				];

				if(Auth::attempt($credentials))
				{
					return Redirect::route("user/profile");
				}
			}

			$data["errors"] = new MessageBag(["password" => ["Username and/or password invalid."]]);
			$data["username"] = Input::get("username");

			return Redirect::route("user/login")->withInput($data);
			
		}

		
		return View::make("user/login", $data);
	}

	public function requestAction()
	{
		$data = ["request" => Input::old("requested")];

		if(Input::server("REQUEST_METHOD")=="POST")
		{
			$validator = Validator::make(Input::all(), [
				"email" => "required"
				]);

			if($validator->passes())
			{
				$credentials = ["email"=>Input::get("email")];
				Password::remind($credentials, function($message, $user)
				{
					//TODO
					$message->from("taroliu0907@gmail.com");
				});



				$data["requested"] = true;

				return Redirect::route("user/request")->withInput($data);
			}
			
		}

		return View::make("user/request", $data);
	}

	public function resetAction()
	{
		$token = "?token=".Input::get("token");

		$errors = new MessageBag();

		//TODO
		if($old=Input::old("errors"))
		{
			$errors = $old;
		}
		$data = ["token" => $token, "errors" => $errors];

		if(Input::server("REQUEST_METHOD") == "POST")
		{
			$validator = Validator::make(Input::all(),[
				"email" => "required|email",
				"password" => "required|min:6",
				"password_confirmation" => "same:password",
				"token" => "exists:token,token"
				]);

			if($validator->passes())
			{	
				//TODO
				// $credentials = ["email" => Input::get("email")];
				$credentials = [
				"email" => Input::get("email"), 
				"password" => Input::get("password"), 
				"password_confirmation" => Input::get("password_confirmation"), 
				"token" => Input::get("token")
				];

				Password::reset($credentials,
					function($user, $passsword)
					{
						$user->password = Hash::make($passsword);
						$user->save();

						Auth::login($user);
						//return Redirect::route("user/profile");
						return "You are passed 2";
					});
			}

			$data["email"]  = Input::get("email");
			$data["errors"] = $validator->errors();

			return Redirect::to(URL::route("user/reset").$token)->withInput($data);
		}

		return View::make("user/reset", $data);
	}

	public function profileAction()
	{
		return View::make("user/profile");
	}

	public function logoutAction()
	{
		Auth::logout();
		return Redirect::route("user/login");
	}
}