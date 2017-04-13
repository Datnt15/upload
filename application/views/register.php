<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo base_url(); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title><?php echo $title?></title>

	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

	<!-- text fonts -->
	<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-editable.min.css" />

	<!--[if lte IE 9]>
		<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
	<![endif]-->
	<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
	<![endif]-->

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>

<body class="login-layout">
	<div class="main-container">
		<div class="main-content">
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<div class="login-container">
						<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
						<div class="space-20"></div>

						<div class="position-relative">

							<div id="signup-box" class="signup-box visible widget-box no-border">
								<div class="widget-body">
									<div class="widget-main">
										<h4 class="header green lighter bigger">
											<i class="ace-icon fa fa-users"></i>
											Đăng ký
										</h4>

										<div class="space-6"></div>
										
										<p> Vui lòng điền đầy đủ thông tin: </p>

										<?php echo form_open();	 ?>
											
											<fieldset>
												<label class="block clearfix">
													<span class="block input-icon input-icon-left">
														<input type="text" name="username" id="username" class="form-control" placeholder="Tên đăng nhập" required="" />
														<i class="ace-icon fa fa-user"></i>
													</span>
												</label>

												<label class="block clearfix">
													<span class="block input-icon input-icon-left">
														<input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" required="" />
														<i class="ace-icon fa fa-lock"></i>
													</span>
												</label>
												
												<label class="block clearfix">
													<span class="block input-icon input-icon-left">
														<input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
														<i class="ace-icon fa fa-envelope"></i>
													</span>
												</label>

												<label class="block clearfix">
													<select name="user_type" id="user_typer" required class="form-control">
									                    <option value="<?= STUDENT_USER_TYPE; ?>" selected>
									                        <?= strtoupper(str_replace('_', " ", STUDENT_USER_TYPE)); ?>
									                    </option>
									                    <option value="<?= BUSSINESS_USER_TYPE; ?>">
									                        <?= strtoupper(str_replace('_', " ", BUSSINESS_USER_TYPE)); ?>
									                    </option>
									                    <option value="<?= BUSSINESS_STAFF_USER_TYPE; ?>">
									                        <?= strtoupper(str_replace('_', " ", BUSSINESS_STAFF_USER_TYPE)); ?>
									                    </option>
									                    <option value="<?= INSTRUCTOR_TEACHER_USER_TYPE; ?>">
									                        <?= strtoupper(str_replace('_', " ", INSTRUCTOR_TEACHER_USER_TYPE)); ?>
									                    </option>
									                    <option value="<?= CURATOR_TEACHER_USER_TYPE; ?>">
									                        <?= strtoupper(str_replace('_', " ", CURATOR_TEACHER_USER_TYPE)); ?>
									                    </option>
									                </select>
												</label>
												<div class="user_type_meta">
													
													<label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input type="text" name="student_id" id="student_id" class="form-control" placeholder="Mã số sinh viên">
															<i class="ace-icon fa fa-graduation-cap"></i>
														</span>
													</label>
													
												</div>
                
												<!--< label class="block">
													<input type="checkbox" class="ace" />
													<span class="lbl">
														I accept the
														<a href="#">User Agreement</a>
													</span>
												</label> -->
												<div class="clearfix center">
													<input type="hidden" name="access_token" value="<?= $ci_nonce; ?>">
													<button type="submit" class="form-control btn-sm btn btn-success">
														<span class="bigger-110">Đăng ký</span>
													</button>
												</div>
											</fieldset>
										<?php echo form_close(); ?>
									</div>

									<div class="toolbar center">
										<a href="login" class="back-to-login-link">
											Đăng nhập
										</a>
									</div>
								</div><!-- /.widget-body -->
							</div><!-- /.signup-box -->
						</div><!-- /.position-relative -->
					</div>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.main-content -->
	</div><!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script src="assets/js/jquery-2.1.4.min.js"></script>
	<script src="assets/js/bootstrap-datepicker.min.js"></script>


	<!-- <![endif]-->

	<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPMTQLm7omfoGI6tpH2AtNrL-_5aBdLsE&libraries=places"
        async defer></script>
    <script type="text/javascript">
    </script>
	<script type="text/javascript">
    	function initAutoComplete(input){
    		var autocomplete = new google.maps.places.Autocomplete(input);
    	}
		jQuery(function($) {
			$("#user_typer").change(function() {
				$(".user_type_meta").slideUp(400);
				var user_type = $(this).val();
				var meta = '';
				switch (user_type){
					case "<?php echo STUDENT_USER_TYPE;?>":
						meta = '<label class="block clearfix"><span class="block input-icon input-icon-left">'+
							'<input type="text" name="student_id" id="student_id" class="form-control" placeholder="Mã số sinh viên">'+
							'<i class="ace-icon fa fa-graduation-cap"></i></span></label>';
						break;
					case "<?php echo BUSSINESS_USER_TYPE;?>":
					<?php if (count($companies)): ?>
						meta = '<label class="block clearfix"><span class="block input-icon input-icon-left">'+
							'<select class="form-control" name="company_id" id="company_id">'+
							<?php foreach ($companies as $company) {
								echo "'<option value=\'".$company['company_id']."\'>".$company['company_name']."</option>'+";
							}?>
							'<option value="other">Công ty khác</option></select>';
						break;
					<?php else: ?>
						meta = '<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_name" id="company_name" class="form-control" placeholder="Tên công ty">'+
						'<i class="ace-icon fa fa-building-o"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_domain" id="company_domain" class="form-control" placeholder="Trang web công ty">'+
						'<i class="ace-icon fa fa-globe"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_phone" id="company_phone" class="form-control" placeholder="Số máy công ty">'+
						'<i class="ace-icon fa fa-phone"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_date_created" id="company_date_created" class="form-control" placeholder="Ngày thành lập">'+
						'<i class="ace-icon fa fa-calendar-o"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_address" id="company_address" class="form-control" placeholder="Địa chỉ công ty">'+
						'<i class="ace-icon fa fa-map-marker "></i></span></label>';
						break;
					<?php endif; ?>
					case "<?php echo BUSSINESS_STAFF_USER_TYPE;?>":
					<?php if (count($companies)): ?>
						meta = '<label class="block clearfix"><span class="block input-icon input-icon-left">'+
							'<select class="form-control" name="company_id" id="company_id">'+
							<?php foreach ($companies as $company) {
								echo "'<option value=\'".$company['company_id']."\'>".$company['company_name']."</option>'+";
							}?>
							'<option value="other">Công ty khác</option></select>';
						break;
					<?php else: ?>
						meta = '<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_name" id="company_name" class="form-control" placeholder="Tên công ty">'+
						'<i class="ace-icon fa fa-building-o"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_domain" id="company_domain" class="form-control" placeholder="Trang web công ty">'+
						'<i class="ace-icon fa fa-globe"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_phone" id="company_phone" class="form-control" placeholder="Số máy công ty">'+
						'<i class="ace-icon fa fa-phone"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_date_created" id="company_date_created" class="form-control" placeholder="Ngày thành lập">'+
						'<i class="ace-icon fa fa-calendar-o"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_address" id="company_address" class="form-control" placeholder="Địa chỉ công ty">'+
						'<i class="ace-icon fa fa-map-marker "></i></span></label>';
						break;
					<?php endif; ?>
					default:
						break;
				}
				if (meta != '') {
					$(".user_type_meta").slideDown(400).html(meta);				
				}
				$("#company_date_created").datepicker({format: 'yyyy-mm-dd'});
				initAutoComplete( document.getElementById('company_address') );

			});
			$('.user_type_meta').on("change", "#company_id", function(){
				if ($(this).val() == 'other' ) {
					$(".user_type_meta").slideUp(400);
					$(".user_type_meta").slideDown(400).html('<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_name" id="company_name" class="form-control" placeholder="Tên công ty">'+
						'<i class="ace-icon fa fa-building-o"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_domain" id="company_domain" class="form-control" placeholder="Trang web công ty">'+
						'<i class="ace-icon fa fa-globe"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_phone" id="company_phone" class="form-control" placeholder="Số máy công ty">'+
						'<i class="ace-icon fa fa-phone"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_date_created" id="company_date_created" class="form-control" placeholder="Ngày thành lập">'+
						'<i class="ace-icon fa fa-calendar-o"></i></span></label>'+
						'<label class="block clearfix"><span class="block input-icon input-icon-left">'+
						'<input type="text" name="company_address" id="company_address" class="form-control" placeholder="Địa chỉ công ty">'+
						'<i class="ace-icon fa fa-map-marker "></i></span></label>'
					);
					$("#company_date_created").datepicker({format: 'yyyy-mm-dd'});
					initAutoComplete( document.getElementById('company_address') );
				}
			});
		});
	</script>
</body>
</html>
