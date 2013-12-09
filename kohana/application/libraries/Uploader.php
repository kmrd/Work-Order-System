<?php // if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploader_Core {

	protected $upload_dir = ''; 
	protected $maxfilesize = 10;	// maximum filesize in MB
	
    function __construct()
    {
    	$this->upload_dir = Kohana::config('upload.upload_dir');
		$this->maxfilesize = Kohana::config('upload.maxfilesize');
	}
		
	// Set the upload directory
	function set_upload_dir($dir)
	{
		$this->upload_dir = $dir;
	}

	// Get the upload directory
	function get_upload_dir()
	{
		return $this->upload_dir;
	}

	/**
	 * Accept an upload
	 *
	 * @access public
	 * @return array
	 */
	function upload()
	{
		// set initial state of our return emssage
		$return 	= array();
		$status		= "";
		$error		= false;
		
		// 
		if(sizeof($_REQUEST) == 0)
			$error = 'No upload was specified';
		
		$result = array();
		$result['time'] = date('r');
		$result['addr'] = substr_replace(gethostbyaddr($_SERVER['REMOTE_ADDR']), '******', 0, 6);
		$result['agent'] = $_SERVER['HTTP_USER_AGENT'];
		
		if (count($_GET))
			$result['get'] = $_GET;
		if (count($_POST))
			$result['post'] = $_POST;
		if (count($_FILES))
			$result['files'] = $_FILES;


		// deal with chunking
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		
		if (!$error && (!isset($_FILES['file']) || !is_uploaded_file($_FILES['file']['tmp_name'])))
			$error = 'Invalid Upload';
		
		ini_set('gd.jpeg_ignore_warning', 1);
		
		if (!$error && $_FILES['file']['size'] > $this->maxfilesize * 1024 * 1024)
			$error = 'Please upload only files smaller than '.$this->maxfilesize.' MB.';
		
		if (($chunks == 0) && (!$error && !($size = @getimagesize($_FILES['file']['tmp_name']) ) ))
			$error = 'Please upload only images, no other files are supported.';
		
		if (($chunks == 0) && (!$error && $size[2] != IMAGETYPE_JPEG))
			$error = 'Image is not JPEG.';

		if (($chunks == 0) && (!$error && ($size[0] > 10000) && ($size[1] < 10000)))
			$error = 'Only images not exceeding 10000x10000 pixels are accepted.';

		if ($error !== false)
			return array(
					'status' => 'error',
					'error' => $error
					);
	
		// ---------------- Finished error checking ---------------- //
			
		@set_time_limit(10 * 60); // set it to 10 minutes
		
		$cleanupTargetDir = true; // Remove old files
		$maxFileAge = 5 * 3600; // Temp file age in seconds

		// Get parameters
		$filename = (isset($_REQUEST['name'])) ? $_REQUEST['name'] : '';
		
		// Clean the filename for security reasons
		$filename = preg_replace('/[^\w\._]+/', '_', $filename);
		
		// Make sure the filename is unique but only if chunking is disabled
		if ($chunks < 2 && file_exists($this->upload_dir . $filename)) {
			$ext = strrpos($filename, '.');
			$filename_a = substr($filename, 0, $ext);
			$filename_b = substr($filename, $ext);
		
			$count = 1;
			while (file_exists($this->upload_dir . $filename_a . '_' . $count . $filename_b))
				$count++;
		
			$filename = $filename_a . '_' . $count . $filename_b;
		}
		
		$filePath = $this->upload_dir . $filename;

		// create the upload directory if we need to
		if (!is_dir($this->upload_dir))
			mkdir($this->upload_dir,0755);

		// Remove old temp files	
		if ($cleanupTargetDir && is_dir($this->upload_dir) && ($dir = opendir($this->upload_dir))) {
			while (($file = readdir($dir)) !== false) {
				$tmpfilePath = $this->upload_dir . $file;
		
				// Remove temp file if it is older than the max age and is not the current file
				if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge) && ($tmpfilePath != "{$filePath}.part")) {
					@unlink($tmpfilePath);
				}
			}
			closedir($dir);
		} else {
			return array('status' => 'error', 'msg' => 'Failed to open temp directory.');
		}
						
		// Look for the content type header
		if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		
		if (isset($_SERVER["CONTENT_TYPE"]))
			$contentType = $_SERVER["CONTENT_TYPE"];
		
		// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				// Open temp file
				$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
				if ($out) {
					// Read binary input stream and append it to temp file
					$in = fopen($_FILES['file']['tmp_name'], "rb");
		
					if ($in) {
						while ($buff = fread($in, 4096))
							fwrite($out, $buff);
					} else {
						return array('status' => 'error', 'msg' => 'Failed to open input stream.', 'code' => '101');
					}
					fclose($in);
					fclose($out);
					@unlink($_FILES['file']['tmp_name']);
				} else {
					return array('status' => 'error', 'msg' => 'Failed to open output stream.', 'code' => '102');
				}
			} else {
				return array('status' => 'error', 'msg' => 'Failed to move uploaded file.', 'code' => '103');
			}
		} else {
			// Open temp file
			$out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
			if ($out) {
				// Read binary input stream and append it to temp file
				$in = fopen("php://input", "rb");
		
				if ($in) {
					while ($buff = fread($in, 4096))
						fwrite($out, $buff);
				} else
					return array('status' => 'error', 'code' => '101', 'message' => 'Failed to open input stream.');
		
				fclose($in);
				fclose($out);
			} else
				return array('status' => 'error', 'code' => '102', 'message' => 'Failed to open output stream.');
		}
		
		// Check if file has been uploaded
		if (!$chunks || $chunk == $chunks - 1) {
			// Strip the temp .part suffix off 
			rename("{$filePath}.part", $filePath);
		}
		
		$return['name'] = $filename;
		$return['filepath'] = $filePath;
		
		$info = @getimagesize($filePath);

		if ($info) {
			$return['width'] = $info[0];
			$return['height'] = $info[1];
			$return['mime'] = $info['mime'];
		}
		
		// do something when the chunking is complete
		if(($chunks == 0) || ($chunk == ($chunks - 1)))
		{
			$return['status'] = 'success';
		}
		
		return $return;
	}	
	
}


/* End of file ImageUploader.php */
/* Location: ./application/modules/account/libraries/ImageUploader.php */

?>