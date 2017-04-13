<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {
		self::save_data();
		switch ($this->session->user_type) {
			case 'student':
				$data['user'] = $this->UserModel->get_user_data(['uid'=>$this->session->uid])[0];
				$data['user_meta'] = $this->UserModel->get_user_meta(['uid'=>$this->session->uid]);
				$data['title'] = $data['user']['fullname'] != '' ? $data['user']['fullname'] . ' - Trang cá nhân' : $data['user']['username'] . ' - Trang cá nhân' ;
				$data['ci_nonce'] = $this->ci_nonce;
				$this->load->view('student/student_header', $data);
				$this->load->view('student/student_sidebar');
				$this->load->view('student/student_content');
				break;
			case 'business':
				$this->load->view('business/business_header');
				$this->load->view('business/business_sidebar');
				$this->load->view('business/business_content');
				break;
			case 'admin':
				$this->load->view('admin/admin_header');
				$this->load->view('admin/admin_sidebar');
				$this->load->view('admin/admin_content');
				$this->load->view('admin/admin_footer');
				break;
			case 'business_staff':
				$this->load->view('business_emp/business_emp_header');
				$this->load->view('business_emp/business_emp_sidebar');
				$this->load->view('business_emp/business_emp_content');
				break;
			case 'instructor_teacher':
				$this->load->view('teacher_ql/teacher_ql_header');
				$this->load->view('teacher_ql/teacher_ql_sidebar');
				$this->load->view('teacher_ql/teacher_ql_content');
				break;
			case 'curator_teacher':
				$this->load->view('teacher_hd/teacher_hd_header');
				$this->load->view('teacher_hd/teacher_hd_sidebar');
				$this->load->view('teacher_hd/teacher_hd_content');
				break;
			default:
				$this->load->view('newmainpage/mainpage-header');
				$this->load->view("Mainpage");
				$this->load->view('newmainpage/mainpage-footer');
				break;

		}
		$this->load->view('profile_footer');
		
	}


	protected function save_data(){
		$form_ci_nonce = $this->input->post('ci_nonce');
		if (isset($form_ci_nonce) && $form_ci_nonce == $this->ci_nonce) {
			$meta_data = $this->input->post('meta');
			$where = ['uid'=>$this->session->uid];
			// Cập nhật thông tin chính của user
			$this->UserModel->update_user_data($this->input->post('main'), $where);

			// Cập nhật các thông tin phụ
			foreach ($meta_data as $key => $value) {
				$where['meta_key'] = $key;
				if ( empty( $this->UserModel->get_user_meta($where) ) ) {
					$this->UserModel->add_user_meta([
							'meta_key' => $key,
							'meta_value' => $value,
							'uid' => $this->session->uid
						]);
				}else{
					$this->UserModel->update_user_meta(['meta_value' => $value], $where);
				}
			}
			$this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('msg', 'Cập nhật thông tin thành công!');
			if($_FILES['avatar']['size']){
				$config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|jpeg|png|gif';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('avatar')){
                	$this->session->set_flashdata('type', 'danger');
                    $this->session->set_flashdata('msg', 'Đã xảy ra lỗi trong quá trình tải ảnh lên! Vui lòng thực hiện lại');
                }else{
                	$data = array('upload_data' => $this->upload->data());
                    $where['meta_key'] = 'avatar';
					if ( empty( $this->UserModel->get_user_meta($where) ) ) {
						$this->UserModel->add_user_meta([
								'meta_key' => 'avatar',
								'meta_value' => 'uploads/' . $data['upload_data']['file_name'],
								'uid' => $this->session->uid
							]);
					}else{
						$this->UserModel->update_user_meta(['meta_value' => 'uploads/' . $data['upload_data']['file_name']], $where);
					}
                }
			}
			
			$this->session->set_userdata("ci_nonce", substr(md5(microtime()),0,15));
            redirect('/profile');

		}elseif(isset($form_ci_nonce) && $form_ci_nonce != $this->ci_nonce){
			$this->session->set_flashdata('type', 'danger');
            $this->session->set_flashdata('msg', 'Mã access token không khớp. Vui lòng tải lại trang!');
            redirect('/profile');
		}
	}

}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */