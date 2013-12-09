<?php defined('SYSPATH') OR die('No direct access allowed.');

/*
*
*
*	Images for a Work Order docket
*
*
*/

class Image_Model extends ORM_Tree {

	protected $belongs_to = array('order');


	// make this hierarical (ie. tree link structure)
    protected $ORM_Tree_children = 'images';
    protected $ORM_Tree_parent_key = 'parent_id';     // Set the column which holds this model's parent

	//echo Kohana::debug(ORM::factory("Category", 42)->children->as_array()); //returns the children for the category with id 42
	//echo Kohana::debug(ORM::factory("Category", 4)->parent->name); //returns the parent name of the category with ID 4

	//protected $has_and_belongs_to_many = array('roles');

	//protected $has_many = array('eats');

	//protected $has_one = array('appointment');
		 
//	public function unique_key($id = NULL)
//	{
//		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
//		{
//			return 'username';
//		}
// 
//		return parent::unique_key($id);
//	}
	

	
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
				->add_rules('filename','required')
				;

		//$array->add_callbacks('email', array($this,'_email_exists'));

		///if(isset($inputarray['password2']) && !is_null($inputarray['password2']))
			//$array->add_rules('password', 'required','matches[password2]');

		// only do a username check if it exists (ie. on the registration page)
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
	/*

	public function validate_with_campuses(array & $array, $save = FALSE)
	{
		// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('username', 'required', array($this, '_name_exists'))
				->add_rules('email', 'required', 'email', 'matches[email2]')
				->add_rules('password', 'required','matches[password2]')
				->add_rules('phone', 'required')
				->add_rules('fname', 'required')
				->add_rules('lname', 'required')
				;

		$array->add_callbacks('campus', array($this,'_check_for_campus'));

		return parent::validate($array, $save);
	}
	*/
	public function validatelogin(array & $array, $save = FALSE)
	{
		// Initialise the validation library and setup some rules
		$array = Validation::factory($array)
				->pre_filter('trim')
				->add_rules('email', 'required', 'email')
				->add_rules('password', 'required');
		//$array->add_callbacks('email', array($this,'_email_exists'));

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