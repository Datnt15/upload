<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index(){
		$this->session->unset_userdata("is_logged_in");
		$this->session->unset_userdata("uid");
		$this->session->unset_userdata("user_type");
		$this->session->sess_destroy();
		redirect("login");
	}

}

/* End of file Logout.php */
/* Location: ./application/controllers/Logout.php */