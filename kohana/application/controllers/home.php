<?php defined('SYSPATH') OR die('No direct access allowed.');


class Home_Controller extends Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->auth = Auth::instance();
	}



	public function index()
	{
		// check if we're logged in -- go to dashboard if we are
		if ($this->auth->logged_in())
			url::redirect('/dashboard');

		$target = ($this->input->post()) ? $this->input->post() : array();
		$data = arr::extract($target, 'username', 'password');

		// If there is a POST and POST is not empty
		if ($this->input->post())
		{
			// Instantiate a new person
			$user = ORM::factory('user')->where('username', $data['username'])->find();
			
			// If the post data validates using the rules setup in the user model
			if ($user->validate_login($data))
			{
				//Successfully validated the input -- check if they authenticate	
				if(!$user->loaded)
				{
					$data->add_error('username', 'not_found');
				}
				elseif($this->auth->login($user->username, $data['password']))
				{
					if($user->resetpassword > 0)
					{
						// hash the password
						$user->password = Auth::instance()->hash_password($data['password']);
						$user->resetpassword = 0;
						$user->save();
					}

					url::return_redirect('/dashboard');
				}
				else
				{
					$data->add_error('password', 'incorrect_password');
				}
			}

			$errors = $data->errors('form_errors');
		}


		$view = View::factory('home');
		$view->data = $data;
		if(isset($errors))
			$view->errors = $errors;
		$view->render();
		
		$template = View::factory('template');
		$template->header = '';
		$template->bodyclass = 'home';
		$template->content = $view;
		$template->render();
		echo $template;
	}

	public function generatepassword()
	{
		echo Auth::instance()->hash_password('1214');
	}

	public function logout()
	{
		$this->auth->logout();
		url::redirect('/');
	}
}