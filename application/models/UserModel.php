<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	//==================================================================================
	//								COMPANY ACTION
	//==================================================================================
	

	/**
	 * Thêm công ty vào db
	 * @param [array] $data [chứa thông tin cơ bản của công ty]
	 * EX: $data = [
	 * 		'company_name' 			=> 'Tên công ty là gì cũng đc nà', 
	 * 		'company_address' 		=> 'số 1 đại cồ việt', 
	 * 		'company_domain' 		=> 'domain.com.vn',
	 * 		'company_date_created' 	=> '2000-05-15'
	 * 	]
	 * 	@return boolean
	 */
	public function add_company($data){
		return $this->db->insert(COMPANY_TABLE, $data) ? $this->db->insert_id() : 0;
	}

	/**
	 * Lấy thông tin cụ thể của công ty
	 * @param [array|srting] $where [Điều kiện để lấy thông tin]
	 * EX: $where = ['company_id' => 1]
	 * @return Boolean
	 */
	public function get_precifix_company($where){
		return $this->db->select('*')->where($where)->get(COMPANY_TABLE)->result_array();
	}


	/**
	 * Lấy thông tin của nhiều công ty
	 * @param [array|srting] $where [Điều kiện để lấy thông tin, bố trống thì sẽ lấy hết]
	 * EX: $where = ['company_id' => 1]
	 * @return Boolean
	 */
	public function get_companies($where = 'company_id > 0', $limit = 0, $offset = 0){
		$offset = $offset > 0 ? $offset : 0 ;
		$limit = $limit > 0 ? $limit : PER_PAGE ;
		return $this->db->select('*')->where($where)->get(COMPANY_TABLE, $offset, $limit)->result_array();
	}


	/**
	 * Lấy thông tin cụ thể của công ty
	 * @param [array] $data [chứa thông tin cần cập nhật]
	 * EX: $where = ['company_name' => "Một cái tên khác của công ty mà bạn muốn thay"]
	 * @param [array|srting] $where [Điều kiện để cập nhật]
	 * EX: $where = ['company_id' => 1], $where = 'company_id=1';
	 * @return Boolean
	 */
	public function update_company($data, $where){
		return $this->db->where($where)->update(COMPANY_TABLE, $data);
	}


	/**
	 * Xóa bỏ thông tin của một hoặc nhiều công ty nào đó
	 * @param  [array|string] $where [Điều kiện để xóa, nếu trống thì sẽ xóa hết]
	 * @return [Boolean]
	 */
	public function delete_company($where = '1'){
		return $this->db->where($where)->delete(COMPANY_TABLE);
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


	/**
	 * Lấy toàn bộ thông tin của các skills
	 * @return [mảng dữ liệu chứa thông tin của toàn bộ các skills]
	 */
	public function get_skills(){
		return $this->db->select('*')->get(SKILL_TABLE)->result_array();
	}


	/**
	 * Lấy thông tin chính của user
	 * @param  [array|string] $where [Điều kiện lấy thông tin]
	 * @return [array]        [mảng thông tin]
	 */
	public function get_skill_by_condition($where){
		return $this->db->where($where)->get(SKILL_TABLE)->result_array();
	}


	/**
	 * Thêm skill
	 * @param [array] $data [chứa thông tin cơ bản của skill]
	 * EX: $data = [
	 * 		'skill_name' 	=> 'Nguyễn Tiên Đạt', 
	 * 		'cat_id' 		=> '123'
	 * 	]
	 */
	public function add_new_skill($data){
		return $this->db->insert(SKILL_TABLE, $data);
	}

	public function get_topic($offset = 0){
		$limit = $offset . PER_PAGE;
		$res = $this->db->select('*')->from(TOPIC_TABLE)->join(USER_TABLE, USER_TABLE.'.uid='.TOPIC_TABLE. '.professor_id', 'left')->where(['is_approved' => '1'])->limit($limit, $offset)->get()->result_array();
		if (count($res)) {
			foreach ($res as &$topic) {
				$topic['skills_required'] = $this->db->select('skill_name')->where('skill_id IN ('.$topic['skills_required'].')')->get(SKILL_TABLE)->result_array();
				// $topic['user_avatar'] = $this->db
			}
		}
		return $res;

	}

	public function count_all_table($table){
		return $this->db->get($table)->num_rows();
	}

	private function unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 
}

/* End of file UserModel.php */
/* Location: ./application/models/UserModel.php */

?>