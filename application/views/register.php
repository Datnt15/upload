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
	<link rel="stylesheet" href="assets/css/font-awesome.min.css" />

	<!-- text fonts -->
	<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" />

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

                
												<label class="block">
													<input type="checkbox" class="ace" />
													<span class="lbl">
														I accept the
														<a href="#">User Agreement</a>
													</span>
												</label> 
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
	<script src="assets/js/bootstrap.min.js"></script>


	<!-- <![endif]-->

	<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
	</script>
</body>
</html>
