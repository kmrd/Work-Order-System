<?php defined('SYSPATH') OR die('No direct access allowed.');

class Dashboard_Controller extends Controller {
	function __construct()
	{
		parent::__construct();

		$this->session= Session::instance();
		$this->auth = Auth::instance();

		
		if (!$this->auth->logged_in()) // You can put in a role as a parameter for logged_in (ie. 'admin')
		{
			// protect this entire controller
			url::redirect('/');
		}

	}

	public function index() {
		$body = View::factory('dashboard');
		if(isset($errors))
			$body->errors = $errors;
		if(isset($data))
			$body->data = $data;
		$body->render();
		
		$template = View::factory('template');
		$template->title = 'Dashboard';
		$template->content = $body;
		echo $template->render();
	}

	public function post($storeid = false, $postid = false) {


		url::check_login_return(); // check if we're logged in -- if not, go to login and come back here


		$user = ORM::factory('user', Auth::instance()->get_user()->id);

		// todo: make sure this user can modify this store

		// if no storeid provided, this is a new post request -- check if we have a store to post to
		if($storeid === false)
		{
			// If we don't have a store, we have to create one.
			if(sizeof($user->stores) <= 0)
			{
				url::redirect('/store/create');
			}
			elseif(sizeof($user->stores) > 1) // choose a store to use
			{
				// todo: program multiple stores in
				// right now, using the first store that they own
				$store = $user->stores[0];
				$storeid = $store->id;
			}
			else // use the only store that they have (ie. sizeof($user->stores) == 1)
			{
				$store = $user->stores[0];
				$storeid = $store->id;
			}
		}

		// load this store
		$store = ORM::factory('store', security::unscrambleint($storeid));

		// bail if store doesn't exist
		if(!$store->loaded)
			url::redirect('/');

		// if no postid provided, this is a new post request -- redirect to a new post to start in
		if ($postid === false)
		{
			//make a new eat and redirect to use that
			$eat = ORM::factory('eat');
			$eat->name = 'New Eat';
			$eat->user_id = $user->id;
			$eat->store_id = $store->id;
			$eat->published = 0;
			$eat->save();

			url::redirect('/eat/post/'.security::scrambleint($store->id).'/'.security::scrambleint($eat->id));
		}
		else
		{
			$eat = ORM::factory('eat', security::unscrambleint($postid));
		}

		// load this post
		// If there is a post and $_POST is not empty
		$data = arr::extract(  ( $this->input->post() ) ?  $this->input->post() :  $eat->as_array(),
							'name', 'desc', 'type', 'stocktype', 'price', 'priceper'
							);

		// Save any changes
		if ($this->input->post())
		{			
			if($eat->validate($data))
			{		


				// handle the ingredients specially
				$ingredientids = array();
				foreach(explode(  ',', $this->input->post('ingredients')  ) as $ingredientname)
				{
					$ingredient = ORM::factory('ingredient')->where('name', $ingredientname)->find();

					if(!$ingredient->loaded)
					{
						$ingredient->name = trim(security::xss_clean($ingredientname));
						$ingredient->save();
					}
					array_push($ingredientids, $ingredient->id);
				}
				$eat->ingredients = $ingredientids;



				if($this->input->post('postnow') !== false)
					$eat->published = 1;
				else if($this->input->post('savedraft') !== false)
					$eat->published = 0;


				$eat->save();

				echo ('saved successfully');
			}
			else
			{
				$errors = $data->errors('form_errors');
			}

		}


		$body = View::factory('eat_edit');
		$body->eat = $eat;
		$body->store = $store;
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


	public function view($eatid = false) {
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
	}

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