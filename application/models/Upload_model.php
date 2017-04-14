<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	/**
	 * Thêm từ khóa mới vào bảng keywords
	 * @param [mảng] $data [description]
	 * @return  id của record mới insert vào
	 */
	public function add_keyword($data){
		return $this->db->insert('keywords', $data) ? $this->db->insert_id() : 0;
	}


	/**
	 * Lấy thông tin cụ thể của một từ khóa
	 * @param [array|srting] $where [Điều kiện để lấy thông tin]
	 * EX: $where = ['key_id' => 1]
	 * @return mảng dữ liệu
	 */
	public function get_specifix_keyword($where){
		return $this->db->select('*')->where($where)->get('keywords')->result_array();
	}



	/**
	 * Lấy thông tin cụ thể của nhiều từ khóa
	 * @param [array|srting] $where [Điều kiện để lấy thông tin]
	 * @param [int] $limit [số bản ghi sẽ lấy]
	 * @param [int] $offset [bắt đầu lấy từ bản ghi số ...]
	 * EX: $where = ['key_id' => 1]
	 * @return mảng dữ liệu
	 */
	public function get_keywords($where){
		return $this->db->select('keyword')->where($where)->get('keywords')->result_array();
	}

	/**
	 * Thêm thông tin ảnh vào db
	 * @param [type] $data [description]
	 */
	public function add_image($data){
		return $this->db->insert('images', $data) ? $this->db->insert_id() : 0;
	}


	public function delete_image($where)
	{
		return $this->db->where($where)->delete('images');
	}



	/**
	 * Lấy thông tin cụ thể của nhiều ảnh
	 * @param [array|srting] $where [Điều kiện để lấy thông tin]
	 * @param [int] $limit [số bản ghi sẽ lấy]
	 * @param [int] $offset [bắt đầu lấy từ bản ghi số ...]
	 * EX: $where = ['key_id' => 1]
	 * @return mảng dữ liệu
	 */
	public function get_images($where = 'uid=1', $offset = 0, $limit = PER_PAGE){
		$res = $this->db->flush_cache()->select('*')->where($where)->limit($limit, $offset)->order_by('date_created', 'DESC')->get('images')->result_array();
		if (count($res)) {
			foreach ($res as &$img) {
				$img['keywords'] = self::get_keywords('key_id IN ('. $img['keywords'] . ')');
			}
		}
		return $res;
	}


	public function count_all_images_available($where){
		return $this->db->flush_cache()->select('*')->where($where)->get('images')->num_rows();
	}

	public function get_titles(){
		return $this->db->select('title')->get('images')->result_array();
	}

	public function update_image($data, $where){
		return $this->db->where($where)->update('images', $data);
	}
}

/* End of file Upload_model.php */
/* Location: ./application/models/Upload_model.php */