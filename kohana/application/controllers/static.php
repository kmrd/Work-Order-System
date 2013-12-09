<?php defined('SYSPATH') OR die('No direct access allowed.');


class Static_Controller extends Controller {

	function __construct()
	{
		parent::__construct();
		
		// give us access to the school configuration
		//$school = new School_Model;
		//$this->school = $school->getschoolinfo();
	}
	public function about()
	{
		$view = View::factory('about');
		$view->render();
		
		$template = View::factory('template');
		$template->title = 'About Us';
		//$template->css = array('faq');
		//$template->js = array('jquery.showcase-2.0.2.min','slideshow');
		$template->bodyclass = 'about-page';
		$template->content = $view;
		$template->render();
		echo $template;
	}
	public function privacy()
	{
		$view = View::factory('privacy');
		$view->render();
		
		$template = View::factory('template');
		$template->title = 'About Us';
		//$template->css = array('faq');
		//$template->js = array('jquery.showcase-2.0.2.min','slideshow');
		$template->bodyclass = 'about-page';
		$template->content = $view;
		$template->render();
		echo $template;
	}
	public function contact()
	{
		$view = View::factory('contact');
		$view->render();
		
		$template = View::factory('template');
		$template->title = 'About Us';
		//$template->css = array('faq');
		//$template->js = array('jquery.showcase-2.0.2.min','slideshow');
		$template->bodyclass = 'about-page';
		$template->content = $view;
		$template->render();
		echo $template;
	}
}