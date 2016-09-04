<?php

Class UserController extends BaseController
{
	public function getCreate()
		{
			return View::make('user.register');
		}

	public function getLogin()
		{
			return View::make('user.login');
		}

	public function postCreate(){

		$validate = Validator::make(Input::all(), array(

					'username' => 'required|unique:users|min:4',
					'email'	   => 'required|email|unique:users',
					'password' => 'required|min:6',
					'confirm_password' => 'required|same:password',
		));
		if ($validate->fails()){

				return Redirect::route('getCreate')
					->withErrors($validate)->withInput();
		}
		else{

			$user = new User();
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
		
		
			if ($user->save()){

			Mail::send('forum.mailer', array('user'=>$user), function($message){

			$message->to(Input::get('email'), Input::get('username'))->subject('Welcome to BRACU Forum!');
		});

				return Redirect::route('home')
					->with('success','You Registered Successfully. Now you can log in');
				}

			else{

				return Redirect::route('home')
					->with('fail','An Error occured. Please try again.');
			}
		}

	}
		public function postLogin()
			{
				
				$validator = Validator::make(Input::all(), array(

					'email' => 'required',
					'password' => 'required'

					));

					if ($validator->fails()){

						return Redirect::route('getLogin')
							->withErrors($validator)->withInput();
						}
					else{

						$remember = (Input::has('remember')) ? true : false;

						$auth = Auth::attempt(array(
								'email' => Input::get('email'),
								'password' => Input::get('password')

						), $remember );	

						if($auth){
							return Redirect::route('home')->with('info','Welcome back to biTS Forum for BU!');
						}
						else{
							return Redirect::route('getLogin')
								->with('fail', 'You entered wrong login credential, Please try again.')->withInput();
						}	
					}
			}

			public function getChangePassword(){
			
				return View::make('user.password');
		}
		
		public function postChangePassword() {

			$validator = Validator::make(Input::all(),
				array(
					'old_password'	=> 'required',
					'password' 		=> 'required|different:old_password|min:6',
					'password_again'=> 'required|different:old_password|same:password'
				)
			);

			if($validator->fails()) {
				return Redirect::route('getChangepassword')
					->withErrors($validator);
			} 

			else {
				// passed validation

				// Grab the current user
				$user 			= User::find(Auth::user()->id);

				// Get passwords from the user's input
				$old_password 	= Input::get('old_password');
				$password 		= Input::get('password');

				// test input password against the existing one
				if(Hash::check($old_password, $user->getAuthPassword()))
				{
					$user->password = Hash::make($password);

					// save the new password
					if($user->save()) {
						return Redirect::route('home')
								->with('success', 'Your password has been changed.');
					}
				} else {
					return Redirect::route('getChangepassword')
						->with('fail', 'Your old password is incorrect.');
				}
			}

	/* fall back */
	return Redirect::route('account-change-password')
		->with('fail', 'Your password could not be changed.');
		
		}

		public function getLogout(){

			Auth::logout();
			return Redirect::route('home')->with('info','See you soon!');

		}
			public function save(User $user){
           		return $user->save();
        }
		
		public function getProfile($id){

			$user = User::where('id', '=', $id);

		if($user->count()) {
			
			$user = $user->first();
			
			return View::make('forum.profile')
			->with('user', $user);

		}

		return App::abort(404);	
			
		}


}