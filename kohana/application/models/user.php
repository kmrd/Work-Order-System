<?php defined('SYSPATH') OR die('No direct access allowed.');

/*
*
*
*	User (ie. that is using the system -- is logging in/out of the system)
*		- not to be confused with a customer
*
*
*/

class User_Model extends ORM {
	protected $has_and_belongs_to_many = array('roles');

	//protected $has_many = array('eats', 'images', 'avatars', 'stores', 'reviews', 'orders');

	//protected $has_one = array('appointment');
	
	//protected $ignored_columns = array();
	

	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'username';
		}
 
		return parent::unique_key($id);
	}
	

	
	/**
	 * Validates and optionally saves a new user record from an array.
	 *
	 * @param  array    values to check
	 * @param  boolean  save[Optional] the record when validation succeeds
	 * @return boolean
	 */
	public function validate_login(array & $array, $save = FALSE)
	{
				// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('username', 'required')
				->add_rules('password', 'required')
				;

		return parent::validate($array, $save);
	}

/*	public function validateforgotten(array & $array, $save = FALSE)
	{
		// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				//->add_rules('username', 'required', array($this, '_name_not_exists'));
				->add_rules('username', 'required');

		return parent::validate($array, $save);
	}
	public function	validateresetpassword(array & $array, $save = FALSE)
	{
		// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('password', 'required');

		return parent::validate($array, $save);
	}
*/

	/**
	 * Tests if a username exists in the database. This can be used as a
	 * Validation rule.
	 */
	public function _email_exists($array, $field)
	{
		$result = ! (bool) $this->db
			->where(array('email' => $array[$field]))//, 'id !=' => $this->id))
			->count_records($this->table_name);

		if($result) {
			return true;
		} else {
			$array->add_error($field, '_email_exists');
			return false;
		}
 
	}
	/*
	public function _name_not_exists($name)
	{	
		return !$this->_name_exists($name);
	} */
}