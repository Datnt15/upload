<div class="main-content">
    <div class="page-content">

        <div class="page-header">
            <h1>
                Xin chào Nguyễn Tiến Đạt!
            </h1>
        </div><!-- /.page-header -->

        
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="clearfix">
            	<?php if ($this->session->flashdata('type')): ?>
                    <div class="alert alert-<?php echo $this->session->flashdata('type');?> no-margin alert-dismissable" style="float: none; margin: 0 auto;">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="ace-icon fa fa-times"></i>
                        </button>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
            	<?php endif ?>
            </div>
            <div class="vspace-12-sm"></div>
            <div class="space"></div>
            <!-- PAGE CONTENT BEGINS -->
            <div class="page-content">
                <div class="tabbable">
                    <!-- Tab header -->
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#upload-area" aria-expanded="false">
                                <i class="green ace-icon fa fa-cloud-upload bigger-120"></i>
                                Upload
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#gallery-area" aria-expanded="true">
                                <i class="green ace-icon fa fa-picture-o bigger-120"></i>
                                Gallery
                            </a>
                        </li>
                    </ul>
                    <!-- / tab header -->
    
                    <!-- Tab content -->
                    <div class="tab-content">

                        <!-- Upload Area -->
                        <div id="upload-area" class="tab-pane fade active in">
                            <div class="page-header">
                                <h1>
                                    Đăng tải hình ảnh cùng từ khóa                                   
                                </h1>
                            </div><!-- /.page-header -->
                           
                            <form class="form-horizontal" id="upload-form" role="form" action="" method="POST" enctype="multipart/form-data" >
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <input multiple="true" name="images[]" type="file" id="id-input-file-3" required="" />
                                    </div>
                                </div>
                                <div class="space-4"></div>

                                <div class="form-group">
                                    <label class="col-xs-12" for="form-field-tags">Từ khóa (tìm kiếm)</label>

                                    <div class="col-xs-12">
                                        <input type="text" name="keywords" id="form-field-tags" value="" placeholder="Nhập vào từ khóa ..." class="form-control" required="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <button class="btn btn-app btn-xs btn-primary no-radius" type="submit">
                                            <i class="ace-icon fa fa-cloud-upload"></i>
                                            Tải lên
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /Upload Area -->
                        
                        <!-- Gallery -->
                        <div id="gallery-area" class="tab-pane fade">
                            <div class="page-header">
                                <h1>
                                    Quản lý hình ảnh                                    
                                </h1>
                            </div><!-- /.page-header -->

                            <div class="row">
                                <div class="col-xs-12 well">
                                    <form class="form-inline col-xs-8" action="" method="POST" id="filter-form" >
                                        <div class="col-xs-6">
                                            <input type="text" name="title" class="typeahead" placeholder="Title">
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="text" name="tags" id="search-tags" value="" placeholder="Enter tags to search ..."/>
                                            
                                        </div>
                                    </form>

                                </div>
                                <div class="space"></div>
                                <div class="tabbable">
                                    <div class="search-area col-xs-4 pull-right">
                                        <div class="pull-right">
                                            <b class="text-primary">Hiển thị</b>

                                            &nbsp;
                                            <ul id="toggle-layout-format" class="nav nav-tabs btn-group btn-overlap" data-toggle="buttons">
                                                <li class="active">
                                                    <a title="Thumbnail view" class="btn btn-lg btn-white btn-success" data-toggle="tab" href="#grid-view" aria-expanded="false" data-class="btn-success" aria-pressed="true">
                                                        <i class="icon-only ace-icon fa fa-th"></i>
                                                    </a>
                                                    
                                                </li>
                                                <li>
                                                    
                                                    <a title="List view" class="btn btn-lg btn-white btn-success" data-class="btn-success" data-toggle="tab" href="#list-view" aria-expanded="false">
                                                        <i class="icon-only ace-icon fa fa-list"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a title="Table view" class="btn btn-lg btn-white btn-success" data-class="btn-success" data-toggle="tab" href="#table-view" aria-expanded="false">
                                                        <i class="icon-only ace-icon fa fa-table"></i>
                                                    </a>
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 tab-content no-border" id="gallery-content">
                                        <?php if(count($images) ): ?>
                                            <!-- Grid View -->
                                            <div class="tab-pane fade active in" id="grid-view">
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
                                            <div class="tab-pane fade" id="list-view">
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
                                            <div class="tab-pane fade" id="table-view">
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
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div><!-- /.row -->
                
                        </div>
                        <!-- Gallery -->

                    </div>
                    <!-- /Tab content -->

                </div>
                
                <!-- Preview Template for Dropzone -->
                <div id="preview-template" class="hide">
                    <div class="dz-preview dz-file-preview">
                        <div class="dz-image">
                            <img data-dz-thumbnail="" />
                        </div>

                        <div class="dz-details">
                            <div class="dz-size">
                                <span data-dz-size=""></span>
                            </div>

                            <div class="dz-filename">
                                <span data-dz-name=""></span>
                            </div>
                        </div>

                        <div class="dz-progress">
                            <span class="dz-upload" data-dz-uploadprogress=""></span>
                        </div>

                        <div class="dz-error-message">
                            <span data-dz-errormessage=""></span>
                        </div>

                        <div class="dz-success-mark">
                            <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>

                                <i class="fa fa-check fa-stack-1x fa-inverse green"></i>
                            </span>
                        </div>

                        <div class="dz-error-mark">
                            <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>

                                <i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
                            </span>
                        </div>
                        <a class="dz-remove" href="javascript:undefined;" data-dz-remove="">
                            <span class="fa-stack fa-lg bigger-150">
                                <i class="fa fa-circle fa-stack-2x white"></i>
                                <i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
                            </span>
                        </a>
                    </div>
                </div>

                <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="gridSystemModalLabel">Chỉnh sửa ảnh</h4>
                            </div>
                            <div class="modal-body">
                                <div class="clearfix">
                                    <div class="col-xs-4">
                                        <img src="assets/img/image.png" class="img-responsive" id="edit_image_url" alt="">
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="form-group">
                                            <label for="">Tiêu đề:</label>
                                            <input type="text" name="edit_image_title" id="edit_image_title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Từ khóa:</label>
                                            <input type="text" name="edit_image_keys" id="edit_image_keys" class="form-control">
                                        </div>
                                        <input type="hidden" id="edit_image_id" name="edit_image_id">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <!-- /Preview Template for Dropzone -->
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.page-content -->

</div><!-- /.main-content -->
