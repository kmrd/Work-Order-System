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

		$order = ORM::factory('order');
		$order->car_id = $car->id;
		$order->tax = '13';
		$order->servicedate = date('Y-m-d H:i:s'); // use today's date as the default
		$order->save();

		url::redirect('/order/edit/'.$order->id);
	}

	public function edit($orderid = false) {
		if($orderid === false)
			url::redirect('/');

		$order = ORM::factory('order', $orderid);

		if(!$order->loaded)
			url::redirect('/');

		$data = arr::extract(($this->input->post()) ? $this->input->post() : $order->as_array(), 'mileage','worktype','servicedate','notes','tax','discount');

		// Save any changes
		if ($this->input->post())
		{			
			if($order->validate($data))
			{		
				// keep running track of the price (represented as an integer: ie. 5.99 => 599)
				$itemtotal = 0;



				// remove all existing parts
				foreach($order->parts as $part) {
					$part->delete();
				}

				// handle the parts
				foreach($this->input->post('parts') as $index => $name)
				{
					if(strlen(trim($name)) > 0)
					{
						// increase our item total
						$partprice = $this->input->post('partsprice');
						$itemtotal += $partprice[$index] * 100;

						$part = ORM::factory('part');
						$part->name = $name;
						$part->order_id = $order->id;
						$part->price = $partprice[$index] * 100; // storing it without the decimal place
						$part->save();
					}
				}

				// remove all existing service
				foreach($order->services as $service)
				{
					$service->delete();
				}

				// handle the service
				foreach($this->input->post('services') as $index => $name)
				{
					if(strlen(trim($name)) > 0)
					{
						// increase our item total
						$serviceprice = $this->input->post('serviceprice');
						$itemtotal += $serviceprice[$index] * 100;

						$service = ORM::factory('service');
						$service->name = $name;
						$service->order_id = $order->id;
						$service->price = $serviceprice[$index] * 100; // storing it without the decimal place
						$service->save();
					}
				}

				// calculate the total
				$subtotal = ($itemtotal - ($this->input->post('discount') * 100) );
				$tax = $subtotal * ($this->input->post('tax') / 100 / 100);
				$total = $subtotal + $tax;
				//die($total);
				//$total = $total * 100; // store the total as an integer, without cents


				// handle the remaining fields
				$order->mileage = trim($data['mileage']);
				$order->tax = $this->input->post('tax');
				$order->discount = $this->input->post('discount') * 100;
				$order->total = $total;


				// handle the funny dates
				if($data['servicedate'] == '')
					$order->servicedate = date('Y-m-d H:i:s');
				else
					$order->servicedate = date('Y-m-d H:i:s', strtotime($data['servicedate']));


				$order->save();

				$this->session->set('successstatus', 'Work order saved successfully.');

				if($this->input->post('savegoback'))
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
		$body->car = $order->car;
		$body->order = $order;
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->css = array('bootstrap-datetimepicker.min','jquery-ui-1.10.0.custom');
		$template->js  = array('bootstrap-datetimepicker.min','jquery-ui-1.10.3.custom.min','order');
		$template->title = 'Add Work Order';
		$template->content = $body;
		echo $template->render();
	}

	public function printly($orderid = false) {
		if($orderid === false)
			url::redirect('/');

		$order = ORM::factory('order', $orderid);

		if(!$order->loaded)
			url::redirect('/');

		// calculate the subtotal & tax total
		// keep running track of the price (represented as an integer: ie. 5.99 => 599)
		$itemtotal = 0;

		// handle the parts
		foreach($order->parts as $part)
		{
			// increase our item total
			$itemtotal += $part->price * 100;
		}

		// handle the service
		foreach($order->services as $service)
		{
			// increase our item total
			$itemtotal += $service->price * 100;
		}

		// calculate the subtotal & tax
		$subtotal = ($itemtotal - $order->discount) * 100;
		$taxamt = ($subtotal / 100) * ($order->tax / 100 / 100);

		$body = View::factory('order_print');
		$body->car = $order->car;
		$body->order = $order;
		$body->subtotal = $subtotal;
		$body->taxamt = $taxamt;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Print Work Order';
		$template->content = $body;
		$template->js = array('print');
		echo $template->render();
	}


	/*
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
	*/

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

	public function delete($orderid = false) {

		if($orderid === false)
			url::redirect('/');

		$order = ORM::factory('order', $orderid);

		if(!$order->loaded)
			url::redirect('/');

		// get the customer ID before we delete the order
		$customer_id = $order->car->customer->id;

		// delete this order
		$order->delete();

		$this->session->set('successstatus', 'Work order deleted.');

		url::redirect('/customer/view/'.$customer_id);
	}

	public function find() {
		$data = arr::extract(($this->input->post()) ? $this->input->post() : array(), 'job','year','model','make');

		// state flag -- assume we have no customers found
		//$posted = false;

		if($this->input->post())
		{
			// make sure there's at least one criteria to search by:
			if((strlen($data['job']) > 0) || (strlen($data['year']) > 0) || (strlen($data['make']) > 0) || (strlen($data['model']) > 0))
			{
				$db = new Database();

				$querystr = 'SELECT distinct orders.* FROM orders, cars WHERE ';
				$querywhere = array();

				// build our query's where statement
				if(strlen($data['job']) > 0)
					//array_push($querywhere, ' orders.car_id = cars.id AND MATCH(orders.worktype) AGAINST ("'.$data['job'].'" IN BOOLEAN MODE)  '); // not compatible with innodb, need to be using MyISAM table
					array_push($querywhere, ' orders.car_id = cars.id AND orders.worktype LIKE "%'.$data['job'].'%" '); // not compatible with innodb, need to be using MyISAM table
				if(strlen($data['year']) > 0)
					array_push($querywhere, ' cars.year LIKE "%'.$data['year'].'%" ');
				if(strlen($data['make']) > 0)
					array_push($querywhere, ' cars.make LIKE "%'.$data['make'].'%" ');
				if(strlen($data['model']) > 0)
					array_push($querywhere, ' cars.model LIKE "%'.$data['model'].'%" ');

				$querystr .= implode(' AND ', $querywhere);
				$querystr .= ' ORDER BY orders.servicedate DESC';

				// run the query
				$result = $db->query($querystr);

				// setup the ORM:
				$orders = array();
				foreach($result as $row)
				{
					$order = ORM::factory('order', $row->id);
					if($order->loaded)
						array_push($orders, $order);
				}
			}

			$posted = true;
		}
		else {
			
			$posted = false;
		}

		$body = View::factory('order_find');
		$body->data = $data;
		$body->posted = $posted;
		if(isset($orders))
			$body->orders = $orders;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Find Customer';
		$template->bodyclass = 'findcustomer';
		$template->content = $body;
		echo $template->render();
	}

	public function suggest() {

		$terms = array();

		if($this->input->post('term'))
		{
			$term = $this->input->post('term');
			$db = new Database();
			$query = "SELECT max(id) id, worktype
						  FROM orders
						 WHERE worktype like '%$term%'
						 GROUP BY worktype
						 ORDER BY CASE WHEN worktype like '$term %' THEN 0
						               WHEN worktype like '$term%' THEN 1
						               WHEN worktype like '% $term%' THEN 2
						               ELSE 3
						          END, worktype";
			$result = $db->query($query);
			foreach($result as $row)
			{
				array_push($terms, $row->worktype);
			}

			// simple query using ORM
			//$orders = ORM::factory('order')->like( array('worktype' => $this->input->post('term')) )->find_all();
			//foreach($orders as $order)
			//{
			//	array_push($terms, $order->worktype);
			//}
		}

		echo json_encode($terms);
	}

}