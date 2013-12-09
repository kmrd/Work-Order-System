<?php defined('SYSPATH') or die('No direct script access.');
 
class Url extends Url_Core {
 
	public function return_redirect($uri = false)
	{
		// retrive a possible redirect url from the session
		$redirect = Session::instance()->get_once('redirect');

		if($redirect !== false)
			url::redirect($redirect);	// redirect to where the session wanted to bring us to
		elseif($uri !== false)
			url::redirect($uri);		// redirect to the uri as normal
		else
			url::redirect('/');		// redirect to home (standard behaviour of normal redirect

		return;
	}

	// checks the login:
	// if not logged in, save the uri and come back to it after logging in
	// if we are logged in, just allow execution to continue 
	public function check_login_return($urioverride = false)
	{
		if(Auth::instance()->logged_in() === false)
		{
			Session::instance()->set('redirect',Router::$complete_uri);

			if($urioverride !== false)
				url::redirect($urioverride);
			else
				url::redirect('/login');
		}

		return;
	}
 
}
 