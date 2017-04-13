<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Upload_model');
	}

	public function index(){
		$data = [
			'title' => 'Upload Images',
			'images' => $this->Upload_model->get_images()
		];
		$this->load->view('upload/upload-header', $data);
		$this->load->view('upload/sidebar');
		$this->load->view('upload/content');
		$this->load->view('upload/footer');
	}

	// Xử lý upload
	public function do_upload(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'upload-image') {
			$keyswords = $this->input->post('keywords');
			$images = self::reArrayFiles( $_FILES['images'] );
			$target_dir = "uploads/";
			$res = [
				'type' => 'success',
				'mes' => '',
				'data' => []
			];
			$keys = [];
			$keyswords = explode(',', $keyswords);
		    foreach ($keyswords as $value) {
		    	$single_key = $this->Upload_model->get_specifix_keyword(['keyword' => trim($value)]);
		    	if(!empty($single_key)){
		    		array_push($keys, $single_key[0]['key_id']);
		    	}else{
		    		array_push(
		    			$keys, 
		    			$this->Upload_model->add_keyword(['keyword' => trim($value)])
		    		);
		    	}
		    }
		    $keys = implode(',', $keys);
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
				    	$data = [
							'title' 	=> str_replace(".".$imageFileType, "", $image['name']),
							'url' 		=> $image_path,
							'uid' 		=> 1,
							'keywords' 	=> $keys
						];
						$img_id = $this->Upload_model->add_image( $data );
						array_push($res['data'], $data);
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


	public function get_keywords($key){
		$keys = $this->Upload_model->get_keywords("keyword LIKE '%".$key."%'");
		$res = [];
		if (count($keys)) {
			foreach ($keys as $key) {
				array_push($res, $key['keyword']);
			}
		}
		echo json_encode($res);
	}


	public function get_titles(){
		$keys = $this->Upload_model->get_titles();
		$res = [];
		if (count($keys)) {
			foreach ($keys as $key) {
				array_push($res, $key['title']);
			}
		}
		echo json_encode($res);
	}

	public function delete_image()
	{
		$action = $this->input->post('action');
		if (isset($action) && $action == 'delete_image') {
			$where = ['image_id' => $this->input->post('image_id')];
			$image = $this->Upload_model->get_images($where)[0];
			unlink($image['url']);
			$this->Upload_model->delete_image($where);
		}
	}

	public function get_image()
	{
		$action = $this->input->post('action');
		if (isset($action) && $action == 'get_image') {
			$where = ['image_id' => $this->input->post('image_id')];
			echo json_encode($this->Upload_model->get_images($where)[0]);
		}
	}

	public function update_image(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'update_image') {
			$where = ['image_id' => $this->input->post('image_id')];
			$keyswords = $this->input->post('keys');
			$keys = [];
			$keyswords = explode(',', $keyswords);
		    foreach ($keyswords as $value) {
		    	$single_key = $this->Upload_model->get_specifix_keyword(['keyword' => trim($value)]);
		    	if(!empty($single_key)){
		    		array_push($keys, $single_key[0]['key_id']);
		    	}else{
		    		array_push(
		    			$keys, 
		    			$this->Upload_model->add_keyword(['keyword' => trim($value)])
		    		);
		    	}
		    }
		    $keys = implode(',', $keys);
		    $data = [
			    'title' => $this->input->post('title'),
			    'keywords' => $keys
		    ];
		    $this->Upload_model->update_image($data, $where);
		}
	}


}

/* End of file Upload.php */
/* Location: ./application/controllers/Upload.php */