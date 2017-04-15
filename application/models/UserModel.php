<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	//==================================================================================
	//								USERS ACTION
	//==================================================================================
	

	/**
	 * Thêm đối tượng người dùng
	 * @param [array] $data [chứa thông tin cơ bản của người dùng]
	 * EX: $data = [
	 * 		'fullname' 			=> 'Nguyễn Tiên Đạt', 
	 * 		'username' 		=> 'some_user_name_123', 
	 * 		'password' 		=> 'cds6fg434h3jvg2v2v43hrdhewvgv44', // Đã đc mã hóa
	 * 		'email' 	=> 'example@gmail.com',
	 * 		'user_type' => STUDENT_USER_TYPE //Hằng số đc lưu trong file config/constants.php
	 * 	]
	 */
	public function add_user($data){
		return $this->db->insert(USER_TABLE, $data) ? $this->db->insert_id() : 0;
	}

	/**
	 * Thêm thông tin phụ của người dùng
	 * @param [array] $data [chứa thông tin cơ bản của người dùng]
	 * EX: $data = [
	 * 		'uid' 			=> 12, 
	 * 		'meta_key' 		=> 'que_quan', 
	 * 		'meta_value' 	=> 'Hà Nội Bách Khoa'
	 * 	]
	 */
	public function add_user_meta( $data ){
		return $this->db->insert(USER_META_TABLE, $data);
	}

	/**
	 * Sửa đổi thông tin meta của người dùng
	 * @param [array] $data [chứa thông tin cơ bản của người dùng]
	 * EX: $data = [
	 * 		'meta_key' 		=> 'que_quan', 
	 * 		'meta_value' 	=> 'Hà Nội Bách Khoa'
	 * 	]
	 * 	@param [array|string] $where [Điều kiệu để sửa]
	 * 	@return Boolean
	 */
	public function update_user_meta( $data, $where ){
		return $this->db->where($where)->update(USER_META_TABLE, $data);
	}
	

	/**
	 * Sửa đổi thông tin chính của người dùng
	 * @param [array] $data [chứa thông tin cơ bản của người dùng]
	 * EX: $data = [
	 * 		'fullname' 		=> 'Nguyễn Tiên Đạt', 
	 * 		'user_type' 	=> ADMIN_USER_TYPE
	 * 	]
	 * 	@param [array|string] $where [Điều kiệu để sửa]
	 * 	@return Boolean
	 */
	public function update_user_data( $data, $where ){
		return $this->db->where($where)->update(USER_TABLE, $data);
	}

	/**
	 * Lấy thông tin chính của user
	 * @param  [array|string] $where [Điều kiện lấy thông tin]
	 * @return [array]        [mảng thông tin]
	 */
	public function get_user_data($where){
		return $this->db->where($where)->get(USER_TABLE)->result_array();
	}


	/**
	 * Lấy thông tin phụ của user
	 * @param  [array|string] $where [Điều kiện lấy thông tin]
	 * @return [array]        [mảng thông tin]
	 */
	public function get_user_meta($where){
		$meta = array();
		$results = $this->db->where($where)->get(USER_META_TABLE)->result_array();
		foreach ($results as $key => $value) {
			// Nếu có nhiều meta chứa cùng một thông tin của một key
			// Ví dụ: Sở thích (nghe nhạc, xem phim, du lịch, chịch dạo ...)
			if (array_key_exists($value['meta_key'], $meta) ) {
				if (!is_array($meta[$value['meta_key']]) ) {
					$meta[$value['meta_key']] = [ $meta[$value['meta_key']] ];
					array_push($meta[$value['meta_key']], $value['meta_value']);
				}else{
					array_push($meta[$value['meta_key']], $value['meta_value']);
				}
			}else{
				$meta[$value['meta_key']] = $value['meta_value'];
			}
		}
		return $meta;
	}

	/**
	 * Xoá thông tin phụ của user
	 * @param  [array|string] $where [Điều kiện xóa thông tin]
	 * @return [Boolean]
	 */
	public function delete_user_meta($where){
		return $this->db->where($where)->delete(USER_META_TABLE);
	}


	/**
	 * Xoá một bản ghi trên bảng thông tin phụ của user
	 * @param  [array|string] $where [Điều kiện xóa thông tin]
	 * @return [Boolean]
	 */
	public function delete_once_user_meta($where){
		return $this->db->where($where)->limit(1)->delete(USER_META_TABLE);
	}


	public function delete_user($where){
		$uid = $this->db->select('uid')->where($where)->get(USER_TABLE)->result_array();
		if (empty($uid)) {
			return false;
		}
		$uid = $uid[0]['uid'];
		self::delete_user_meta("uid={$uid}");
		return $this->db->where("uid={$uid}")->delete(USER_TABLE);
	}

}

/* End of file UserModel.php */
/* Location: ./application/models/UserModel.php */

?>