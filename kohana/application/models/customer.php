<?php defined('SYSPATH') OR die('No direct access allowed.');

class Customer_Model extends ORM {

	//protected $has_and_belongs_to_many = array('roles');

	protected $has_many = array('cars');

	//protected $has_one = array('appointment');
	
	//protected $ignored_columns = array('programA','programB','programC','campus');
	

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
	public function validate(array & $array, $save = FALSE)
	{
		// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('fname', 'required')
				->add_rules('lname', 'required')
				->add_rules('email', 'trim')
				->add_rules('phone', 'trim')
				->add_rules('forumusername', 'trim')
				->add_rules('forum', 'trim')
				;

		return parent::validate($array, $save);
	}

}