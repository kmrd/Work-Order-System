<?
$lang = array
(
        // Change 'field' to the name of the actual field (e.g., 'email').
	'username' => array
		(
                    'required' => 'Please enter a username.',
                    'not_found' => 'User does not exist.',
					'_name_not_exists'	=> 'This number is not registered on this site.',
                    'default'  => 'Invalid Input.',
		),
	'password' => array
		(
                    'required' => 'Please enter a password.',
					'not_found'		=> 'This password is incorrect.',
					'incorrect_password' => 'The password you have entered is incorrect.',
					'matches'	=> 'The passwords must match.',
                    'default'  => 'Invalid Input.',
		),
	'password2' => array
		(
                    'required' => 'You must enter a password.',
					'not_found'		=> 'This password is incorrect.',
					'incorrect_password' => 'This password you have entered is incorrect.',
					'matches'	=> 'The passwords must match.',
                    'default'  => 'Invalid Input.',
		),
	'email' => array
		(
                    'required' => 'Please enter an email.',
					'email'		=> 'Please enter a valid email.',
					'_email_exists'	=> 'This email address is already being used.',
					'matches'	=> 'The email addresses must match.',
					'not_found' => 'This email address does not exist.',
                    'default'  => 'Invalid Input.',
		),
	'email2' => array
		(
                    'required' => 'Please enter an email.',
					'email'		=> 'Please  enter a valid email.',
					'_email_exists'	=> 'This email address is already being used.',
					'matches'	=> 'The email addresses must match.',
                    'default'  => 'Invalid Input.',
		),
	'phone' => array
		(
                    'required' => 'You must enter a phone number.',
					'email'		=> 'You must enter a valid phone number.',
                    'default'  => 'Invalid Input.',
		),
	'fname' => array
		(
                    'required' => 'You must enter a first name.',
                    'default'  => 'Invalid Input.',
		),
	'lname' => array
		(
                    'required' => 'You must enter a last name.',
                    'default'  => 'Invalid Input.',
		),
		
	'name' => array
		(
                    'required' => 'Please enter a name.',
                    'default'  => 'Invalid Input.',
		),
	'year' => array
		(
                    'required' => 'Please enter a year.',
                    'default'  => 'Invalid Input.',
		),
	'make' => array
		(
                    'required' => 'Please enter a make.',
                    'default'  => 'Invalid Input.',
		),
	'model' => array
		(
                    'required' => 'Please enter a model.',
                    'default'  => 'Invalid Input.',
		),
);
?>