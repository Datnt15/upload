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


}

/* End of file Upload.php */
/* Location: ./application/controllers/Upload.php */