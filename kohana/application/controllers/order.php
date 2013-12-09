<?php defined('SYSPATH') OR die('No direct access allowed.');

class Order_Controller extends Controller {
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

	public function add($carid = false) {
		if($carid === false)
			url::redirect('/');

		$car = ORM::factory('car', $carid);

		if(!$car->loaded)
			url::redirect('/');

		$data = arr::extract(($this->input->post()) ? $this->input->post() : array(), 'mileage','worktype','servicedate','service','parts','notes');

		// Save any changes
		if ($this->input->post())
		{			
			$order = ORM::factory('order');

			if($order->validate($data))
			{		
				$order->car_id = $car->id;
				// handle the funny dates
				$order->servicedate = date('Y-m-d H:i:s', strtotime($data['servicedate']));
				//var_dump($data);
				//die();
				$order->save();

				$this->session->set('successstatus', 'Order added successfully.');

				url::redirect('/customer/view/'.$order->car->customer->id);
			}
			else
			{
				$errors = $data->errors('form_errors');
			}
		}


		$body = View::factory('order_add');
		$body->car = $car;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->css = array('bootstrap-datetimepicker.min');
		$template->js = array('bootstrap-datetimepicker.min', 'order');
		$template->title = 'Add Work Order';
		$template->content = $body;
		echo $template->render();
	}

	public function edit($orderid = false) {
		if($orderid === false)
			url::redirect('/');

		$order = ORM::factory('order', $orderid);

		if(!$order->loaded)
			url::redirect('/');

		$data = arr::extract(($this->input->post()) ? $this->input->post() : $order->as_array(), 'mileage','worktype','servicedate','service','parts','notes');

		// Save any changes
		if ($this->input->post())
		{			
			//$order = ORM::factory('order');

			if($order->validate($data))
			{		
				//$order->car_id = $car->id;
				// handle the funny dates
				$order->servicedate = date('Y-m-d H:i:s', strtotime($data['servicedate']));
				$order->save();

				$this->session->set('successstatus', 'Order added successfully.');

				url::redirect('/customer/view/'.$order->car->customer->id);
			}
			else
			{
				$errors = $data->errors('form_errors');
			}
		}


		$body = View::factory('order_edit');
		$body->car = $order->car;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->css = array('bootstrap-datetimepicker.min');
		$template->js = array('bootstrap-datetimepicker.min', 'order');
		$template->title = 'Add Work Order';
		$template->content = $body;
		echo $template->render();
	}

	/*
	public function edit($orderid = false) {
		url::check_login_return('/'); // check if we're logged in -- if not, go to login and come back here

		if($orderid === false)
			url::redirect('/dashboard');

		$order = ORM::factory('order', $orderid);

		if(!$order->loaded)
			url::redirect('/dashboard');

		$car = $order->car;

		$data = arr::extract(($this->input->post()) ? $this->input->post() : $order->as_array(), 'desc');

		// Save any changes
		if ($this->input->post())
		{			
			if($order->validate($data))
			{		
				$order->save();

				$this->session->set('state', 'order updated.');

				if($this->input->post('savereturn'))
					url::redirect('/customer/view/'.$order->car->customer->id);
				else
					url::redirect('/order/edit/'.$order->id);
			}
			else
			{
				$errors = $data->errors('form_errors');
			}

		}


		$body = View::factory('order_edit');
		$body->car = $car;
		$body->order = $order;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Add Car';
		$template->content = $body;
		echo $template->render();
	} */

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

	/*
	public function edit($id = false){

		// check if we're logged in -- if not, go to login and come back here
		url::check_login_return();

		if($id === false)
			url::redirect('/');

		// get this eat:
		$eat = ORM::factory('eat', security::unscrambleint($id));

		if(!$eat->loaded)
			url::redirect('/');

		// todo: check if this id is editable by this user

		$data = arr::extract($eat->as_array(), 'name', 'desc', 'stocktype', 'price');
		$data['allergy'] = $eat->allergies;
	
		if ($this->input->post())
		{
			$data = arr::extract($this->input->post(), 'name', 'desc', 'stocktype', 'allergy', 'price');

			if($eat->validate($data))
			{					
				$user = ORM::factory('user', Auth::instance()->get_user()->id);
				
				// handle the allergies separately
				// remove all allergies
				foreach($eat->allergies as $allergy)
				{
					$eat->remove($allergy);
				}

				if(is_array($data['allergy']) && (sizeof($data['allergy'])> 0))
				{
					foreach($data['allergy'] as $allergy)
					{
						$allergyObj = ORM::factory('allergy')->where(array('name' => $allergy))->find();
						$eat->add($allergyObj);
					}
				}

				$eat->user_id = $user;
				$eat->save();
			}
		}
		else
		{
		}

		$allergies = ORM::factory('allergy')->find_all();

		$body = View::factory('eat_edit');
		$body->eat = $eat;
		$body->allergies = $allergies;
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

	public function delete($eatid = false) {

		if($eatid === false)
			url::redirect('/eat/view/'.security::scrambleint($eatid));

		// todo: make sure this user can delete this eat
		$eat = ORM::factory('eat', security::unscrambleint($eatid));

		if(!$eat->loaded)
			url::redirect('/');

		$eat->active = 0;
		$eat->save();

		url::redirect('/stores/'.security::scrambleint($eat->store->id));
	}

	public function buy() {
		if($this->input->post('eatid') === false)
			url::redirect('/');

		if($this->input->post('qty') === false)
			url::redirect('/eats/'.$this->input->post('eatid'));
	
		$qty = $this->input->post('qty');


		// get this eat
		$eat = ORM::factory('eat', security::unscrambleint($this->input->post('eatid')));

		if(!$eat->loaded)
			url::redirect('/');

		// does this person have a credit card on file?
		// get them to put one in
		// to do: figure out credit card system


		$body = View::factory('buy');
		$body->eat = $eat;
		$body->qty = $qty;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Buy';
		$template->content = $body;
		echo $template->render();
	}

	public function pay() {
		if($this->input->post('eatid') === false)
			url::redirect('/');

		if($this->input->post('qty') === false)
			url::redirect('/eats/'.$this->input->post('eatid'));
	
		$qty = $this->input->post('qty');

		// get this eat
		$eat = ORM::factory('eat', security::unscrambleint($this->input->post('eatid')));

		if(!$eat->loaded)
			url::redirect('/');

		$data = arr::extract(($this->input->post()) ? $this->input->post() : array(), 'cardnum');

		if($this->input->post())
		{
			// todo incorporate the payment system
			//if(strlen($this->input->post('cardnum')) <= 0)
			//	$errors['cardnum'] = 'Not a valid card number';

			$payment = ORM::factory('payment');

			if($payment->validate($data))
			{
				//echo 'ok';
				// make a new order for this
				$order = ORM::factory('order');
				$order->qty = $qty;
				$order->price = $eat->price;
				$order->priceper = $eat->priceper;
				$order->currency = $eat->store->currency;
				//$order->eat_id = $eat->id;
				$order->eat_id = $eat->id;
				$order->user_id = $this->user->id;
				$order->save();

				// make a new payment for this
				$payment->cardnum = $data['cardnum'];
				$payment->order_id = $order->id;
				$payment->user_id = $this->user->id;
				$payment->save();

				// make a reviews object (purchaser -> purchasee)
				$review = ORM::factory('review');
				$review->owner_id = $this->user->id;
				$review->user_id = $eat->user->id;
				$review->eat_id = $eat->id;
				$review->order_id = $order->id;
				$review->save();

				// make a reviews object (purchasee -> purchaser)
				$review->clear();
				$review->owner_id = $eat->user->id;
				$review->user_id = $this->user->id;
				$review->eat_id = $eat->id;
				$review->order_id = $order->id;
				$review->save();


				// todo: allow these users to contact each other
				

				//echo 'payment was successful';
				url::redirect('/eat/paymentsuccess/'.security::scrambleint($payment->id));
			}
			else
			{
				$errors = $data->errors('form_errors');
				//echo 'no dice';
			}

			// does this person have a credit card on file?
			// get them to put one in
			// to do: figure out credit card system


		}


		$body = View::factory('pay');
		$body->eat = $eat;
		$body->qty = $qty;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Buy';
		$template->content = $body;
		echo $template->render();
	}

	public function paymentsuccess($paymentid = false) {
		if($paymentid === false)
			url::redirect('/');

		// todo: make sure this user is allowed tos ee this payment

		$payment = ORM::factory('payment', security::unscrambleint($paymentid));

		if(!$payment->loaded)
			url::redirect('/eats/'.security::scrambleint($payment->order->eat->id));

		echo 'congrats, payment was a scuccess';
	}
}