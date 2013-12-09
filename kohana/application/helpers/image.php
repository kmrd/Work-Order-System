<?php defined('SYSPATH') or die('No direct script access.');

class Image extends Image_Core {

	public static function display($imgIterator = null, $width = null, $height = null, $schema = Image::AUTO)
	{
		if(($imgIterator === null) || ($height === null) || ($width === null))
			return;

		if(sizeof($imgIterator) > 0)
		{
			$parentimg = $imgIterator[0];
		}
		else
		{
			$parentimg = $imgIterator;
		}

		//echo $parentimg->filename;
		// check the image database for children that are of the dimensions we want
		$childimgs = $parentimg->where(array('height' => $height, 'width' => $width))->children;

		if(sizeof($childimgs) > 0)
		{
			return $childimgs[0];
		}
		else
		{
			$upload_dir = Kohana::config('upload.upload_dir') . $parentimg->user->id .'/';

			$this->resize($width, $height, $schema);
			$this->quality(90);
			$this->save($upload_dir . $parentimg->filename . '-' . $height.'x'.$width);

			//$resizer = new ImageResizer($parentimg->filename);
			//$resizer->resizeImage($width, $height);
			//$resizer->saveImage(Kohana::config('upload.upload_dir') . $parentimg->user->id .'/'.$parentimg->filename);
			//saveImage('images/cars/large/output.jpg', 100);
		}

	}
}
?>