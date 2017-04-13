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
		self::do_upload();
		$this->load->view('upload/content');
		$this->load->view('upload/footer');
	}


	public function search_image($page = 1){
		$data = [
			'title' => 'Searching Images',
			'is_search_page' => true
		];
		$this->load->view('upload/upload-header', $data);
		$this->load->view('upload/sidebar');
		$this->load->view('upload/search');
		$this->load->view('upload/footer');
	}

	public function do_upload(){
		$keywords = $this->input->post('keywords');
		if (isset($keywords)) {
			print_r($this->input->post('keywords'));
			print_r( self::reArrayFiles( $_FILES['images'] ) );
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