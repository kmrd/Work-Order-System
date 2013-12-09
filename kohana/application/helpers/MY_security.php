<?php defined('SYSPATH') or die('No direct script access.');
 
class Security extends Security_Core {
 
	public function scrambleint($int = false)
	{
		if($int === false)
			return;

		// is this thing actually a number?
		if(!is_numeric($int))
			return;
		
		return base_convert($int, 10, 36);
	}

	public function unscrambleint($int = false)
	{
		if($int === false)
			return;

		return base_convert($int, 36, 10);
	}

}
 