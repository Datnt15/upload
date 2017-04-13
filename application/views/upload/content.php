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
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#upload-area" aria-expanded="false">
                                <i class="green ace-icon fa fa-cloud-upload bigger-120"></i>
                                Tải ảnh lên
                            </a>
                        </li>

                        <li class="">
                            <a data-toggle="tab" href="#gallery-area" aria-expanded="true">
                                <i class="green ace-icon fa fa-picture-o bigger-120"></i>
                                Gallery
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="upload-area" class="tab-pane fade active in">
                            <p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
                        </div>

                        <div id="gallery-area" class="tab-pane fade">
                            <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
                        </div>
                    </div>
                </div>
                <form action="/" class="dropzone well" id="dropzone" enctype="multipart/form-data">
                    <div class="fallback">
                        <input name="file" type="file" multiple="" />
                    </div>
                </form>
                <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input multiple="" type="file" id="id-input-file-3" />
                        </div>
                    </div>
                    <div class="space-4"></div>

                    <div class="form-group">
                        <label class="col-xs-12" for="form-field-tags">Keywords</label>

                        <div class="col-xs-12">
                            <input type="text" name="tags" id="form-field-tags" value="Ảnh bìa" placeholder="Enter tags ..." class="form-control" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button class="btn btn-app btn-xs btn-primary no-radius" type="submit">
                                <i class="ace-icon fa fa-cloud-upload"></i>
                                Upload
                            </button>
                            <button class="btn btn-app btn-xs btn-danger no-radius" type="reset">
                                <i class="ace-icon fa fa-undo"></i>
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
                                
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
            </div>
            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.page-content -->

</div><!-- /.main-content -->
