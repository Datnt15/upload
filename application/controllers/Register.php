<?php 
if (!defined('BASEPATH'))
exit('No direct script access allowed');
  
class Register extends CI_Controller {

    private $ci_nonce;
    function __construct() {
        parent::__construct();
        // Nếu chưa khởi tạo access token\
        if (!$this->session->has_userdata('ci_nonce')) {
            $this->session->set_userdata("ci_nonce", substr(md5(microtime()),0,15));
        }


        $this->ci_nonce = $this->session->ci_nonce;
        
        if ($this->session->is_logged_in) {
            redirect('profile','refresh');
        }

        // Load libraries
        $this->load->library('form_validation');
        
        // Load models
        $this->load->model('UserModel');
    }


    public function index() {
        // Đặt các luật kiểm tra các trường của form
        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|trim|is_unique[user.username]|regex_match[/^[A-Za-z0-9\s-_]{4,}$/i]');
        $this->form_validation->set_rules("password', 'Mật khẩu', 'required|regex_match[/^[A-Za-z_0-9-_]{4,15}[^'\x22\s@!]+$/]");
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]|callback_is_valid_school_email');
        $this->form_validation->set_rules( 'access_token', 'Access Token', 'required|callback_is_match_access_token');

        // Đặt thông báo khi các trường không thỏa mãn điều kiện đầu vào
        $this->form_validation->set_message('is_match_access_token', '%s không khớp! Vui lòng tải lại trang');
        $this->form_validation->set_message('required', 'Vui lòng không bỏ trống trường %s!');
        $this->form_validation->set_message('min_length', '%s phải dài hơn %d ký tự!');
        $this->form_validation->set_message('max_length', '%s phải ngắn hơn %d ký tự!');
        $this->form_validation->set_message('valid_email', 'Địa chỉ email không hợp lệ!');
        $this->form_validation->set_message('is_unique', '%s đã được sử dụng!');
        $this->form_validation->set_message('regex_match', '%s không hợp lệ!');
        if (!$this->form_validation->run()){
             
            $data = [
                'title'     => "Đăng ký",
                'ci_nonce'  => $this->ci_nonce,
                'companies' => $this->UserModel->get_companies()
            ];
            $this->load->view('register', $data);
        }
        else{ 
            $user_content = [
                'username'  => $this->input->post('username'),
                'password'  => md5($this->input->post('password') . SALT),
                'email'     => $this->input->post('email'),
                'user_type' => $this->input->post('user_type')
            ];
            $uid = $this->UserModel->add_user($user_content);
            if ($uid) {
                $company_id = 0;
                if (isset($_POST['company_name'])) {
                    $company_id = $this->add_company([
                        'company_name'          => $this->input->post('company_name'),
                        'company_address'       => $this->input->post('company_address'),
                        'company_domain'        => $this->input->post('company_domain'),
                        'company_phone'         => $this->input->post('company_phone'),
                        'company_date_created'  => $this->input->post('company_date_created')
                    ]);
                }
                elseif (isset($_POST['company_id'])) {
                    $company_id = $_POST['company_id'];
                }
                if ($company_id) {
                    $this->UserModel->add_user_meta([
                        'uid'       => $uid ,
                        'meta_key'  => 'company_id',
                        'meta_value'=> $company_id
                    ]);
                }
                
                if (isset($_POST['student_id'])) {
                    $this->UserModel->add_user_meta([
                        'uid'       => $uid ,
                        'meta_key'  => 'student_id',
                        'meta_value'=> $_POST['student_id']
                    ]);
                }

                // Cài đặt thông báo
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('msg', 'Đăng ký thành công, vui lòng đăng nhập');
                redirect('login');
                
            }

        }
        
    }


    /**
     * Thêm người dùng hệ thống
     * @param [array] $data [thông tin cơ bản của người dùng]
     */
    private function add_user($data = null){
        if ($data == null) {
            return false;
        }
        return $this->UserModel->add_user($data);
    }

    /**
     * Thêm thông tin công ty đối tác
     * @param [array] $data [mảng dữ liệu]
     */
    private function add_company($data = null){
        if ($data == null) {
            return false;
        }
        return $this->UserModel->add_company($data);
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

   

    // Kiểm tra tính hợp lệ của password
    public function is_valid_school_email($str){
        return true;
    }
}
?>