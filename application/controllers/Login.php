<?php 
if (!defined('BASEPATH'))
exit('No direct script access allowed');
  
class Login extends CI_Controller {

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
        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|trim|regex_match[/^[A-Za-z0-9_-]{4,15}$/i]');
        $this->form_validation->set_rules("password', 'Mật khẩu', 'required|trim|regex_match[/^[A-Za-z_0-9-]{4,15}$/i]");
        $this->form_validation->set_rules( 'access_token', 'Access Token', 'required|trim|callback_is_match_access_token');

        // Đặt thông báo khi các trường không thỏa mãn điều kiện đầu vào
        $this->form_validation->set_message('is_match_access_token', '%s không khớp!');
        $this->form_validation->set_message('required', 'Vui lòng không bỏ trống trường %s!');
        $this->form_validation->set_message('min_length', '%s phải dài hơn %d ký tự!');
        $this->form_validation->set_message('max_length', '%s phải ngắn hơn %d ký tự!');
        $this->form_validation->set_message('valid_email', 'Địa chỉ email không hợp lệ!');
        $this->form_validation->set_message('is_unique', '%s đã được sử dụng!');
        $this->form_validation->set_message('regex_match', '%s không hợp lệ!');
        if (!$this->form_validation->run()){
            $data = [
                'title'     => "Đăng nhập",
                'ci_nonce'  => $this->ci_nonce,
                'companies' => $this->UserModel->get_companies()
            ];
            $this->load->view('login', $data);
        }

        if (isset($_POST['username'])) {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password').SALT);
            $user = $this->UserModel->get_user_data(['username' => $username, 'password' => $password]);
            if(count($user)){
                // Cài đặt thông báo
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('msg', 'Đăng nhập thành công');
                $this->session->set_userdata('is_logged_in', true);
                $this->session->set_userdata('uid', $user[0]['uid']);
                $this->session->set_userdata('user_type', $user[0]['user_type']);
                redirect('profile');
            }else{
                // Cài đặt thông báo
                $this->session->set_flashdata('type', 'danger');
                $this->session->set_flashdata('msg', 'Tên đăng nhập hoặc mật khẩu không đúng');
                redirect('/login');
            }
        }

        if (isset($_POST['new_uid'])) {
            $company_id = 0;
            $uid = $this->input->post('new_uid');
            $this->UserModel->update_user_data(
                ['user_type' => $this->input->post('user_type')],
                ['uid' => $uid]
            );
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
            if ($company_id > 0) {
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
            $this->session->set_flashdata('msg', 'Đăng ký và cập nhật thông tin thành công!');
            $this->session->set_userdata('is_logged_in', true);
            $this->session->set_userdata('uid', $uid);
            $this->session->set_userdata('user_type', $this->input->post('user_type'));
            redirect('profile');
                
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

    public function reset_password_request(){

        if (isset($_POST['email_address'])) {
            $to = $this->input->post('email_address');
            $this->load->library('email');

            $this->email->from('tiendatbt@gmail.com', 'Nguyễn Tiến Đạt');
            $this->email->to($to);

            $this->email->subject('RESET PASSWORD');
            $this->email->message("Xin chào, chúng tôi nhận được yêu cầu thay đổi mật khẩu của bạn. Vui lòng truy cập vào đường dẫn sau để thực hiện thay đổi: " . base_url('/reset_password/' . base64_encode($to)));

            $this->email->send();
            // Cài đặt thông báo
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('msg', 'Đường dẫn đã được gửi tới email của bạn. Vui lòng kiểm tra email và thay đổi mật khẩu.');
            redirect('/login');
        }
    }

    public function login_with_social(){
        if (isset($_POST['avatar'])) {
            $email = $this->input->post('email');
            $result = [];
            $user = $this->UserModel->get_user_data(array('email' => $email));
            if (count($user)) {
                // Cài đặt thông báo
                $this->session->set_flashdata('type', 'success');
                $this->session->set_flashdata('msg', 'Đăng nhập thành công');
                $this->session->set_userdata('is_logged_in', true);
                $this->session->set_userdata('uid', $user[0]['uid']);
                $this->session->set_userdata('user_type', $user[0]['user_type']);
                $res['type'] = 'login_success';
            }else{
                
                // Đăng ký user mới
                $new_uid = $this->UserModel->add_user([
                    'username'  => $this->input->post('user_id'),
                    'fullname'  => $this->input->post('fullname'),
                    'password'  => md5('facebook_login'.SALT),
                    'email'     => $this->input->post('email'),
                    'user_type' => 'student',
                    'is_social_login' => 1
                ]);
                $this->UserModel->add_user_meta([
                    'meta_key'      => 'avatar',
                    'meta_value'    => $this->input->post('avatar'),
                    'uid'           => $new_uid    
                ]);
                $res['type']    = 'register_success';
                $res['new_uid'] = $new_uid;
            }
            echo json_encode($res);
        }
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

}
?>