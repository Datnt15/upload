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
			<div class="page-content">

                <div class="page-header">
                    <h1>
                        Search Images
                        
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12 well">
                        <form class="form-inline col-xs-8" action="" method="POST" id="filter-form" >
                            <div class="col-xs-6">
                                <input type="text" name="title" class="typeahead" placeholder="Title">
                            </div>
                            <div class="col-xs-6">
                                <input type="text" name="tags" id="form-field-tags" value="" placeholder="Enter tags to search ..."/>
                                
                            </div>
                        </form>
                        <div class="search-area col-xs-4">
                            <div class="pull-right">
                                <b class="text-primary">Display</b>

                                &nbsp;
                                <div id="toggle-result-format" class="btn-group btn-overlap" data-toggle="buttons">
                                    <label title="Thumbnail view" class="btn btn-lg btn-white btn-success active" data-class="btn-success" aria-pressed="true">
                                        <input type="radio" value="2" autocomplete="off" />
                                        <i class="icon-only ace-icon fa fa-th"></i>
                                    </label>

                                    <label title="List view" class="btn btn-lg btn-white btn-success" data-class="btn-success">
                                        <input type="radio" value="1" checked="" autocomplete="off" />
                                        <i class="icon-only ace-icon fa fa-list"></i>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="space"></div>
                    <div class="col-xs-12">
                        <div class="col-xs-3 col-sm-3 col-xs-6 col-md-3 grid-view">
                            <div class="img-thumb">
                                <img src="assets/img/image.png" class="img-responsive" alt="">
                            </div>
                            <div class="img-info">
                                <h3>Image title go here</h3>

                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
                
            </div><!-- /.page-content -->
        </div><!-- /.col -->
    </div><!-- /.page-content -->

</div><!-- /.main-content -->
