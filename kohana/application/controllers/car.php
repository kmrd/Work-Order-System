<?php defined('SYSPATH') OR die('No direct access allowed.');

class Car_Controller extends Controller {
	function __construct()
	{
		parent::__construct();

		$this->session= Session::instance();
		$this->auth = Auth::instance();

		if (!$this->auth->logged_in())
		{
			// protect this entire controller
			url::redirect('/');
		}

	}

	public function index() {
		return;
	}

	public function add($customerid = false) {

		url::check_login_return('/'); // check if we're logged in -- if not, go to login and come back here

		$data = arr::extract(($this->input->post()) ? $this->input->post() : array(), 'year','make','model','color','trim','vin');

		// Save any changes
		if ($this->input->post())
		{			
			$car = ORM::factory('car');

			if($car->validate($data))
			{		
				if($customerid !== false)
				{
					$customer = ORM::factory('customer', $customerid);
					if($customer->loaded)
					{
						$car->customer_id = $customerid;
					}
				}
				$car->save();

				$this->session->set_flash('successstate', 'Car added successfully.');

				if($this->input->post('savereturn') !== false)
					url::redirect('/customer/view/'.$car->customer->id);
				else
					url::redirect('/car/edit/'.$car->id);
			}
			else
			{
				$errors = $data->errors('form_errors');
			}

		}


		$body = View::factory('car_add');
		$body->customerid = $customerid;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Add Customer';
		$template->content = $body;
		echo $template->render();
	}

	public function edit($carid = false) {
		url::check_login_return('/'); // check if we're logged in -- if not, go to login and come back here

		if($carid === false)
			url::redirect('/dashboard');

		$car = ORM::factory('car', $carid);

		if(!$car->loaded)
			url::redirect('/dashboard');


		$data = arr::extract(($this->input->post()) ? $this->input->post() : $car->as_array(), 'id', 'year','make','model','color','trim','vin');

		// Save any changes
		if ($this->input->post())
		{			
			if($car->validate($data))
			{		
				$car->save();

				$this->session->set_flash('successstate', 'Car updated.');


				if($this->input->post('savereturn'))
					url::redirect('/customer/view/'.$car->customer->id);
				else
					url::redirect('/car/edit/'.$car->id);
			}
			else
			{
				$errors = $data->errors('form_errors');
			}

		}


		$body = View::factory('car_edit');
		$body->car = $car;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Add Car';
		$template->content = $body;
		echo $template->render();
	}

	public function view($carid = false) {
		url::check_login_return('/'); // check if we're logged in -- if not, go to login and come back here

		if($carid === false)
			url::redirect('/dashboard');

		$car = ORM::factory('car', $carid);

		if(!$car->loaded)
			url::redirect('/dashboard');

		$body = View::factory('car_view');
		$body->car = $car;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Add Car';
		$template->content = $body;
		echo $template->render();
	}

	public function upload($eatid = false)
	{
		// check if we're logged in -- if not, go to login and come back here
		url::check_login_return('/');

		if($eatid === false)
			return;

		// get this eat:
		$eat = ORM::factory('eat', security::unscrambleint($eatid));

		if(!$eat->loaded)
			return;

		$uploader = new Uploader;
		$upload_dir = $uploader->get_upload_dir();
		$upload_dir .= $eat->user->id . '/'; // file this image under this user's directory

		$uploader->set_upload_dir($upload_dir);

		$result = $uploader->upload();

		// record the uploaded image into the database
		if($result['status'] == 'success')
		{
			$image = ORM::factory('image');
			//$image->user_id 	= Auth::instance()->get_user()->id;
			$image->filename 	= isset($result['name']) ? $result['name'] : '';
			$image->height 		= isset($result['height']) ? $result['height'] : null;
			$image->width 		= isset($result['width']) ? $result['width'] : null;
			$image->eat_id 		= $eat->id;
			$image->user_id		= $eat->user;
			$image->save();
		}
	}


	/*public function view($eatid = false) {
		if($eatid === false)
			url::redirect('/');

		$eat = ORM::factory('eat', security::unscrambleint($eatid));

		// if we can't find this eat
		if(!$eat->loaded)
			url::redirect('/');

		$body = View::factory('eat');
		$body->eat = $eat;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Post';
		$template->js = array(//'plupload/browserplus-2.4.21.min',
							  'jquery-ui.1.10.3',
							  'plupload/plupload.full.min',
							  'plupload/jquery.plupload.queue/jquery.plupload.queue',
							  'post');

		$template->css = array('jquery-ui-1.10.3.custom.min',
							   'plupload/jquery.plupload.queue');
		$template->content = $body;
		echo $template->render();
	}*/

	public function delete($carid = false) {

		if($carid === false)
			url::redirect('/');

		$car = ORM::factory('car', $carid);

		if(!$car->loaded)
			url::redirect('/');


		$body = View::factory('car_delete');
		$body->car = $car;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Add Car';
		$template->content = $body;
		echo $template->render();

	}

	public function deleteconfirm($carid = false) {

		if($carid === false)
			url::redirect('/');

		$car = ORM::factory('car', $carid);

		if(!$car->loaded)
			url::redirect('/');

		// save this customer's identity for reference
		$customer = $car->customer;

		// delete all work orders related to this car
		foreach($car->orders as $order)
		{
			$order->delete();
		}

		// delete this car
		$car->delete();

		$this->session->set_flash('warningstate', 'Car deleted successfully.');

		url::redirect('/customer/view/'.$customer->id);

		$body = View::factory('car_deleteconfirmed');
		$body->car = $car;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Add Car';
		$template->content = $body;
		echo $template->render();

	}

}