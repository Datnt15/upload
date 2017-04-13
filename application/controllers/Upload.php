<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index(){
		$data = [
			'title' => 'Upload Images'
		];
		$this->load->view('upload/upload-header', $data);
		$this->load->view('upload/sidebar');
		$this->load->view('upload/content');
		$this->load->view('upload/footer');
	}

	public function do_upload(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'upload-image') {
			$keyswords = $this->input->post();
			$images = self::reArrayFiles( $_FILES['images'] );
			$target_dir = "uploads/";
			$res = [
				'type' => 'success',
				'mes' => ''
			];
			foreach ($images as $image) {

				$target_file = $target_dir . md5(uniqid(rand(), true).time());

				$uploadOk = 1;
				$imageFileType = pathinfo($image['name'],PATHINFO_EXTENSION);
				// Check if image file is a actual image or fake image
			    $check = getimagesize($image["tmp_name"]);
			    if($check !== false) {
			        $uploadOk = 1;
			    } else {
			    	$res['mes'] .= "The file ". basename( $image["name"]). " is not an image.";
			        $uploadOk = 0;
			    }
				if ($image["size"] > 500000) {
				    $res['mes'] .= "Sorry, the file ". basename( $image["name"]). " is too large.";
				    $uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    $res['mes'] .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				    $res['mes'] .= "Sorry, the file ". basename( $image["name"]). " was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					$image_path = $target_file . "." . $imageFileType;
				    if (move_uploaded_file($image["tmp_name"], $image_path)) {
				        $res['mes'] .= "The file ". basename( $image["name"]). " has been uploaded.";
				    } else {
				        $res['mes'] .= "Sorry, there was an error uploading The file ". basename( $image["name"]);
				    }
				}

			}
			echo json_encode($res);
		}
	}

	private function reArrayFiles(&$file_post) {

	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}


}

/* End of file Upload.php */
/* Location: ./application/controllers/Upload.php */