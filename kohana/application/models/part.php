<?php defined('SYSPATH') OR die('No direct access allowed.');

class Part_Model extends ORM {

	protected $belongs_to = array('orders');

	//protected $has_many = array('images');
	
	//protected $has_one = array();

	//protected $has_and_belongs_to_many = array();
	
	//protected $ignored_columns = array();

	protected $sorting = array('id' => 'desc'); //, 'username' => 'asc');

	
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save[Optional] the record when validation succeeds
	 * @return boolean
	 */
	public function validate(array & $array, $save = FALSE)
	{
		// keep the default input values for us to use later
		$inputarray = $array;

		// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('name', 'required')
				//->add_rules('worktype', 'trim')
				//->add_rules('service', 'trim')
				//->add_rules('servicedate', 'trim')
				//->add_rules('parts', 'trim')
				//->add_rules('notes', 'trim')
				;

		
		//$array->add_callbacks('price', '_remove_cents');
		//$array->add_callbacks('price', array($this,'_remove_cents'));
/*
		if(isset($inputarray['username'])) {
			$array->add_rules('username',	'required');
			$array->add_callbacks('username', array($this,'_username_exists_and_autogenerated'));
		}

		// if there's no password2, treat as a update (ie. password not needed)
		if(isset($inputarray['password2']) && !is_null($inputarray['password2']))
			$array->add_rules('password', 'required','matches[password2]');

		// if there's no email2, treat as an update (ie. only one email field present)
		if(isset($inputarray['email2']) && !is_null($inputarray['email2']))
			$array->add_rules('email', 'required', 'email', 'matches[email2]');

		// if there's a campus indicated, make it required
		if(isset($inputarray['campus']) && !is_null($inputarray['campus']))
			$array->add_callbacks('campus', array($this,'_check_for_campus'));
*/
		return parent::validate($array, $save);
	}

}