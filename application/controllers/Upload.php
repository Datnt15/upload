<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Upload_model');
		$this->load->library('pagination');
	}

	public function index(){
		if ($this->session->has_userdata('title')) {
			$this->session->unset_userdata('title');
		}

		if ($this->session->has_userdata('keyids')) {
			$this->session->unset_userdata('keyids');
		}

		if ($this->session->has_userdata('keywords')) {
			$this->session->unset_userdata('keywords');
		}
		
		$data = [
			'title' => 'Upload Images'
		];
		
		$data['images'] = $this->Upload_model->get_images("image_id > 0", 0);
		$data['num_rows'] = $this->Upload_model->count_all_images_available("image_id > 0");

		$this->load->view('upload/upload-header', $data);
		$this->load->view('upload/sidebar');
		$this->load->view('upload/content');
		$this->load->view('upload/footer');
	}


	public function page($page = NULL){

		$where = "";
		$data = [
			'title' => 'Upload Images'
		];
		if ($page == NULL) {
			$page = 1;
		}
		if ($page != 0 ) {
			$page = $page <= 0 ? 1 : $page;

		}

		if ($this->session->has_userdata('title') && $this->session->title !='') {
			$where .= "title LIKE '%" . $this->session->title . "%'";
		}

		if ($this->session->has_userdata('keyids') && $this->session->keyids != '') {
			foreach (explode(',', $this->session->keyids) as $key ) {
				if ($where != '') {
					$where .= " OR keywords LIKE '%" . $key . "%'";
				}else{
					$where .= "keywords LIKE '%" . $key . "%'";
				}
			}
		}
		if ($where == '') {
			$where = 'image_id > 0';
		}
		$data['images'] = $this->Upload_model->get_images($where, ($page-1)*PER_PAGE);
		$data['num_rows'] = $this->Upload_model->count_all_images_available($where);

		$this->load->view('upload/upload-header', $data);
		$this->load->view('upload/sidebar');
		$this->load->view('upload/content');
		$this->load->view('upload/footer');
	}

	// Xử lý upload
	public function do_upload(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'upload-image') {
			$keywords = $this->input->post('keywords');
			$images = self::reArrayFiles( $_FILES['images'] );
			$target_dir = "uploads/";
			$res = [
				'type' => 'success',
				'mes' => '',
				'data' => []
			];
			$keys = [];
			$keywords = explode(',', $keywords);
		    foreach ($keywords as $value) {
		    	$single_key = $this->Upload_model->get_specifix_keyword(['keyword' => rtrim(ltrim($value)) ]);
		    	if(!empty($single_key)){
		    		array_push($keys, $single_key[0]['key_id']);
		    	}else{
		    		array_push(
		    			$keys, 
		    			$this->Upload_model->add_keyword(['keyword' => rtrim(ltrim($value)) ])
		    		);
		    	}
		    }
		    $keys = implode(',', $keys);
			foreach ($images as $image) {

				$target_file = $target_dir . md5(uniqid(rand(), true).time());

				$uploadOk = 1;
				$imageFileType = pathinfo($image['name'],PATHINFO_EXTENSION);
				// Check if image file is a actual image or fake image
			    $check = getimagesize($image["tmp_name"]);
			    if($check !== false) {
			        $uploadOk = 1;
			    } else {
			    	$res['mes'] .= "The file ". basename( $image["name"]). " is not an image.";
			        $uploadOk = 0;
			    }
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    $res['mes'] .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				    $uploadOk = 0;
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
				    $res['mes'] .= "Sorry, the file ". basename( $image["name"]). " was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					$image_path = $target_file . "." . $imageFileType;
				    if (move_uploaded_file($image["tmp_name"], $image_path)) {
				    	$data = [
							'title' 	=> str_replace(".".$imageFileType, "", $image['name']),
							'url' 		=> $image_path,
							'uid' 		=> 1,
							'keywords' 	=> $keys
						];
						$img_id = $this->Upload_model->add_image( $data );
						array_push($res['data'], $data);
				        $res['mes'] .= "The file ". basename( $image["name"]). " has been uploaded.";
				    } else {
				        $res['mes'] .= "Sorry, there was an error uploading The file ". basename( $image["name"]);
				    }

				}

			}
			echo json_encode($res);
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


	public function get_keywords($key){
		$keys = $this->Upload_model->get_keywords("keyword LIKE '%".$key."%'");
		$res = [];
		if (count($keys)) {
			foreach ($keys as $key) {
				array_push($res, $key['keyword']);
			}
		}
		echo json_encode($res);
	}


	public function get_titles(){
		$keys = $this->Upload_model->get_titles();
		$res = [];
		if (count($keys)) {
			foreach ($keys as $key) {
				array_push($res, $key['title']);
			}
		}
		echo json_encode($res);
	}

	public function delete_image(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'delete_image') {
			$where = ['image_id' => $this->input->post('image_id')];
			$image = $this->Upload_model->get_images($where)[0];
			unlink($image['url']);
			$this->Upload_model->delete_image($where);
		}
	}

	public function get_image(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'get_image') {
			$where = ['image_id' => $this->input->post('image_id')];
			echo json_encode($this->Upload_model->get_images($where)[0]);
		}
	}

	public function update_image(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'update_image') {
			$where = ['image_id' => $this->input->post('image_id')];
			$keywords = $this->input->post('keys');
			$keys = [];
			$keywords = explode(',', $keywords);
		    foreach ($keywords as $value) {
		    	$single_key = $this->Upload_model->get_specifix_keyword(['keyword' => trim($value)]);
		    	if(!empty($single_key)){
		    		array_push($keys, $single_key[0]['key_id']);
		    	}else{
		    		array_push(
		    			$keys, 
		    			$this->Upload_model->add_keyword(['keyword' => trim($value)])
		    		);
		    	}
		    }
		    $keys = implode(',', $keys);
		    $data = [
			    'title' => $this->input->post('title'),
			    'keywords' => $keys
		    ];
		    $this->Upload_model->update_image($data, $where);
		}
	}

	public function reload_images(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'reload_images') {
			$where = "";
			$page = $this->input->post('page');
			$layout = $this->input->post('layout');
			if ($page == NULL) {
				$page = 1;
			}

			if ($page != 0 ) {
				$page = $page <= 0 ? 1 : $page;
			}

			if ($this->session->has_userdata('title') && $this->session->title != '') {
				$where .= "title LIKE '%" . $this->session->title . "%'";
			}

			if ($this->session->has_userdata('keyids') && $this->session->keyids != '') {
				foreach (explode(',', $this->session->keyids) as $key ) {
					if ($where != '') {
						$where .= " OR keywords LIKE '%" . $key . "%'";
					}else{
						$where .= "keywords LIKE '%" . $key . "%'";
					}
				}
			}
			if ($where == '') {
				$where = "image_id > 0";
			}
			self::render_images_content($this->Upload_model->get_images($where, ($page-1)*PER_PAGE),
			$this->Upload_model->count_all_images_available($where), $layout);
		}
	}


	private function render_images_content($images, $total, $layout){
		if(count($images) ): ?>
            <!-- Grid View -->
            <div class="tab-pane fade <?= $layout == '#grid-view' ? 'active in' : '' ?> " id="grid-view">
            <?php foreach ($images as $image): ?>
                <div class="col-xs-6 col-sm-4 col-md-3 single-image">
                    <div class="thumbnail search-thumbnail">
                        <span class="search-promotion label label-warning arrowed-in arrowed-in-right pull-right delete-img" data-img-id="<?= $image['image_id'] ?>">Xóa</span>
                        <span class="search-promotion label label-success arrowed-in arrowed-in-right edit-img" data-img-id="<?= $image['image_id'] ?>">Sửa</span>

                        <img class="media-object" alt="100%x200" style="height: 200px; width: 100%; display: block;" src="<?= base_url().$image['url'] ?>" data-holder-rendered="true">
                        <div class="caption">
                            <h3 class="search-title">
                                <?= $image['title'] ?>
                            </h3>
                            <p>
                                <?php foreach ($image['keywords'] as $key): ?>
                                    <span type="button" class="btn btn-white btn-yellow btn-sm"><?= $key['keyword'] ?></span>
                                <?php endforeach ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
            <!-- /Grid View -->
            <!-- List view -->
            <div class="tab-pane fade <?= $layout == '#list-view' ? 'active in' : '' ?>" id="list-view">
            <?php foreach ($images as $image): ?>
                <div class="col-xs-12 single-image">
                    <div class="media search-media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" alt="72x72" style="width: 72px; height: 72px;" src="<?= base_url().$image['url'] ?>" data-holder-rendered="true">
                            </a>
                        </div>

                        <div class="media-body">
                            <div>
                                <h4 class="media-heading col-xs-6">
                                    <?= $image['title'] ?>
                                </h4>
                                <div class="col-xs-6">
                                    <button class="btn btn-white btn-warning btn-bold pull-right delete-img" data-img-id="<?= $image['image_id'] ?>">
                                        <i class="ace-icon fa fa-trash-o bigger-120 orange"></i>
                                        Xóa
                                    </button>

                                    <button class="btn btn-white btn-info btn-bold pull-right edit-img" data-img-id="<?= $image['image_id'] ?>">
                                        <i class="ace-icon fa fa-pencil-square-o bigger-120 blue"></i>
                                        Sửa
                                    </button>
                                </div>
                            </div>
                            <p>
                                <?php foreach ($image['keywords'] as $key): ?>
                                    <span type="button" class="btn btn-white btn-yellow btn-sm"><?= $key['keyword'] ?></span>
                                <?php endforeach ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
            <?php endforeach ?>
            </div>
            <!-- /List view -->
            <!-- Table view -->
            <div class="tab-pane fade <?= $layout == '#table-view' ? 'active in' : '' ?>" id="table-view">
                <table class="table table-striped table-bordered table-hover no-margin-bottom col-xs-12">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Từ khóa</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($images as $image): ?>
                        <tr class="single-image">
                            <td>
                                <img class="media-object" alt="72x72" style="width: 72px; height: 72px;" src="<?= base_url().$image['url'] ?>" data-holder-rendered="true">  
                            </td>
                            <td><?= $image['title'] ?></td>
                            <td>
                                <?php foreach ($image['keywords'] as $key): ?>
                                    <span type="button" class="btn btn-white btn-yellow btn-sm"><?= $key['keyword'] ?></span>
                                <?php endforeach ?>
                            </td>
                            <td>
                                <button class="btn btn-white btn-info btn-bold edit-img" data-img-id="<?= $image['image_id'] ?>">
                                    <i class="ace-icon fa fa-pencil-square-o bigger-120 blue"></i>
                                    Sửa
                                </button>
                                <button class="btn btn-white btn-warning btn-bold delete-img" data-img-id="<?= $image['image_id'] ?>">
                                    <i class="ace-icon fa fa-trash-o bigger-120 orange"></i>
                                    Xóa
                                </button>
                            </td>
                        </tr>
                        
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <!-- /Table view -->
            <div class="clearfix"></div>
            <?php 
            
            
            $config['base_url'] 		= base_url() . "upload/page/";
            $config['total_rows'] 		= $total;
            $config['per_page'] 		= PER_PAGE;
            $config['num_links'] 		= 3;
            $config['full_tag_open']    = '<ul class="pagination pull-right">';
            $config['full_tag_close']   = '</ul>';
            $config['first_link']       = 'Trang đầu';
            $config['last_link']        = 'Trang cuối';
            $config['next_link']        = '<i class="fa fa-chevron-right" aria-hidden="true"></i>';
            $config['next_tag_open']    = '<li>';
            $config['next_tag_close']   = '</li>';
            $config['first_tag_open']   = '<li>';
            $config['last_tag_open']    = '<li>';
            $config['first_tag_close']  = '</li>';
            $config['last_tag_close']   = '</li>';
            $config['prev_link']        = '<i class="fa fa-chevron-left" aria-hidden="true"></i>';
            $config['prev_tag_open']    = '<li>';
            $config['prev_tag_close']   = '</li>';
            $config['cur_tag_open']     = '<li class="active"><a href="#">';
            $config['cur_tag_close']    = '</a></li>';
            $config['num_tag_open']     = '<li>';
            $config['num_tag_close']    = '</li>';
            $config['use_page_numbers'] = TRUE;
            
            $this->pagination->initialize($config);
            
            echo $this->pagination->create_links(); ?>
        <?php else: ?>
        	<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">
					<i class="ace-icon fa fa-times"></i>
				</button>
				Không tìm thấy kết quả nào!
			</div>
        <?php endif;
	}

	public function search_by_title(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'search_by_title') {
			$where = "";
			$page = 1;
			if (!$this->session->has_userdata('title') && !$this->session->has_userdata('keyids')) {
				$page = $this->input->post('page');
			}

			if ($page != 0 ) {
				$page = $page <= 0 ? 1 : $page;
			}
			$title = $this->input->post('title');
			$keywords = $this->input->post('keys');
			$layout = $this->input->post('layout');
			if ($title != '') {
				$where .= "title LIKE '%" . $title . "%'";
				$this->session->set_userdata('title', $title);
			}
			if ($keywords != '') {
				$this->session->set_userdata('keywords',$keywords);
				$keywords = explode(',', $keywords);
				$keywords = array_unique($keywords);
				$keys = [];
			    foreach ($keywords as $value) {
			    	$value = rtrim(ltrim($value));
			    	$single_key = $this->Upload_model->get_specifix_keyword(['keyword' => $value]);
			    	if(!empty($single_key)){
			    		if ($where != '') {
				    		$where .= " OR keywords LIKE '%" . $single_key[0]['key_id'] . "%'";
			    		}else{
				    		$where .= "keywords LIKE '%" . $single_key[0]['key_id'] . "%'";
			    		}
			    		array_push($keys, $single_key[0]['key_id']);
			    	}
			    }
			    $keys = implode(',', $keys);
			    $this->session->set_userdata('keyids',$keys);
			}
			if ($where == '') {
				$where = 'image_id > 0';
			}
			self::render_images_content($this->Upload_model->get_images($where, ($page-1)*PER_PAGE),
			$this->Upload_model->count_all_images_available($where), $layout);
		}
	}


	public function remove_session(){
		$action = $this->input->post('action');
		if (isset($action) && $action == 'remove_title_session') {
			$this->session->unset_userdata('title');
		}
		if (isset($action) && $action == 'remove_key_session') {
			$this->session->unset_userdata('keyids');
			$this->session->unset_userdata('keywords');
		}
	}

}

/* End of file Upload.php */
/* Location: ./application/controllers/Upload.php */