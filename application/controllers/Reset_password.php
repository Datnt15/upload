<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends CI_Controller {

	private $ci_nonce;
  	function __construct() {
        parent::__construct();
        // Nếu chưa khởi tạo access token\
        if (!$this->session->has_userdata('ci_nonce')) {
            $this->session->set_userdata("ci_nonce", substr(md5(microtime()),0,15));
        }
        $this->ci_nonce = $this->session->ci_nonce;
        
        // Load libraries
        $this->load->library('form_validation');
        
        // Load models
        $this->load->model('UserModel');
    }

    function _remap($param) {
        $this->index($param);
    }

	public function index($email) {
		if ($email == 'index') {
			redirect('/','refresh');
		}
		echo base64_decode($email);
		if( !count($this->UserModel->get_user_data( ['email' => base64_decode($email)] ) ) ){
			$this->session->set_flashdata('type', 'danger');
            $this->session->set_flashdata('msg', 'Token không đúng. Vui lòng gửi lại yêu cầu thau đổi mật khẩu.');
			redirect('/login','refresh');
		}
		// Đặt các luật kiểm tra các trường của form
        $this->form_validation->set_rules("password', 'Mật khẩu', 'required|trim|regex_match[/^[A-Za-z_0-9-]{4,15}$/i]");
        $this->form_validation->set_rules( 'access_token', 'Access Token', 'required|trim|callback_is_match_access_token');

        // Đặt thông báo khi các trường không thỏa mãn điều kiện đầu vào
        $this->form_validation->set_message('is_match_access_token', '%s không khớp!');
        $this->form_validation->set_message('required', 'Vui lòng không bỏ trống trường %s!');
        $this->form_validation->set_message('regex_match', '%s không hợp lệ!');
        if (!$this->form_validation->run()){
            
			$data = [
				'title' => 'Thay đổi mật khẩu',
				'ci_nonce' => $this->ci_nonce
			];
			$this->load->view('reset-password', $data, FALSE);
        }

        if (isset($_POST['new_password'])) {
        	if ($this->UserModel->update_user_data( ['password' => md5($this->input->post('new_password').SALT)], ['email' => base64_decode($email)] )) {
        		// Cài đặt thông báo
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('msg', 'Mật khẩu thay đổi thành công. Vui lòng đăng nhập lại.');
                redirect('/login');
        	}
        }
	}


    // Kiểm tra tính hợp lệ của access token
    public function is_match_access_token($str) {
        $flag = true;
        if ($this->ci_nonce != $str) {
            $flag = false;
        }
        $this->session->set_userdata("ci_nonce", substr(md5(microtime()),0,15));
        return $flag;
    }
}

/* End of file Reset_password.php */
/* Location: ./application/controllers/Reset_password.php */