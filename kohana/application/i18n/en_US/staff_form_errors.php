<?
$lang = array
(
        // Change 'field' to the name of the actual field (e.g., 'email').
	'username' => array
		(
                    'required' => 'You must enter a username.',
					'not_found'		=> 'This username is not registered on this site.',
					'not_staff'		=> 'This username does not belong to a staff member.',
					'_name_exists' => 'This username has already been registered.',
					'_name_not_exists'	=> 'This username is not registered on this site.',
                    'default'  => 'Invalid Input.',
		),
	'location' => array
		(
                    'required' => 'You must enter a location name.',
                    'default'  => 'Invalid Input.',
		),
	'password' => array
		(
                    'required' => 'You must enter a password.',
					'not_found'		=> 'This password is incorrect.',
					'incorrect_password' => 'This password you have entered is incorrect.',
                    'default'  => 'Invalid Input.',
		),
	'email' => array
		(
                    'required' => 'You must enter an email.',
					'email'		=> 'You must enter a valid email.',
					'_email_exists'	=> 'This email address is already being used.',
                    'default'  => 'Invalid Input.',
		),
	'fname' => array
		(
                    'required' => 'You must enter your first name.',
                    'default'  => 'Invalid Input.',
		),
	'lname' => array
		(
                    'required' => 'You must enter your last name.',
                    'default'  => 'Invalid Input.',
		),
	
	'date'  => array
		(
                    'required' => 'You must enter a date.',
                    'default'  => 'Invalid Input.',
		),
	'startTime'  => array
		(
                    'required' => 'You must enter a start time.',
                    'default'  => 'Invalid Input.',
		),
	'endTime'  => array
		(
                    'required' => 'You must enter an end time.',
                    'default'  => 'Invalid Input.',
		),
		
);
?>