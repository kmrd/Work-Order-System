<?php defined('SYSPATH') OR die('No direct access allowed.');

class Car_Model extends ORM {

	//protected $has_and_belongs_to_many = array('customers');

	protected $has_many = array('orders');

	protected $has_one = array('customer', 'profile');
	
	//protected $ignored_columns = array();

	protected $sorting = array('id' => 'desc');
	
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
				->add_rules('year', 'required')
				->add_rules('make', 'required')
				->add_rules('model', 'required')
				->add_rules('color', 'trim')
				->add_rules('trim', 'trim')
				->add_rules('vin', 'trim')
				;

		return parent::validate($array, $save);
	}
}