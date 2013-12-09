<?php defined('SYSPATH') or die('No direct script access.');
/*
 *
 *
 *
 *
 *
 */

class Img_Core {


	//
	//	Checks the database if this image exists in this dimension
	//  - if not, dynamically makes one
	//  - always produces a jpg
	//  - adds the new image into the database
	// 
	public static function display($imgIterator = null, $width = null, $height = null, $schema = Image::AUTO)
	{
		if(($imgIterator === false) || ($imgIterator === null) || ($height === null) || ($width === null))
			return;

		if((sizeof($imgIterator) > 0) && is_array($imgIterator))
		{
			$parentimg = $imgIterator[0];
		}
		else
		{
			$parentimg = $imgIterator;
		}
		
		// check the image database for children that are of the dimensions we want
		if(sizeof($parentimg) == 0)
			return false;

		if($parentimg->parent->loaded)
		{
			$parentimg = $parentimg->parent;
		}

		$childimgs = $parentimg->where(array('height' => $height, 'width' => $width))->children;

		if(sizeof($childimgs) > 0)
		{
			return $childimgs[0];
		}
		else
		{
			$upload_dir = Kohana::config('upload.upload_dir') . $parentimg->user->id .'/';

			$filename = str_replace(array('.jpg','.png','.gif'), '', $parentimg->filename) . '-' . $height.'x'.$width . '.jpg';

			// make sure this file exists
			if(!file_exists($upload_dir . $parentimg->filename))
				return false;

			$image = new Image($upload_dir . $parentimg->filename);
			$image->resize($width, $height, $schema);
			$image->quality(90);
			$image->save($upload_dir . $filename );

			//$img = ORM::factory('image');
			$img = ORM::factory($parentimg->object_name);
			$img->filename = $filename;
			$img->height = $height;
			$img->width = $width;
			$img->parent_id = $parentimg->id;
			//var_dump($parentimg->user->id);
			//die();
			$img->user_id = $parentimg->user->id;
			$img->save();

			return $img;
		}

	}

	public function display_filename($imgIterator = null, $width = null, $height = null, $schema = Image::AUTO)
	{
		$img = img::display($imgIterator, $width, $height, $schema);

		if($img == false)
			return false;//'/assets/imgs/default-avatar.jpg';

		$upload_dir = Kohana::config('upload.upload_dir');

		$owner_id = $img->parent->user->id;

		return '/' . $upload_dir . $owner_id . '/' . $img->filename;
	}
}
?>