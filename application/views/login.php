<!DOCTYPE html>
<html lang="en">
	<head>
		<base href="<?php echo base_url(); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title><?php echo $title; ?></title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
		<link rel="stylesheet" href="assets/css/bootstrap-editable.min.css" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
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
			<div class="space-20"></div>
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<?php if ($this->session->flashdata('type')): ?>
									<div class="alert alert-<?php echo $this->session->flashdata('type');?> no-margin alert-dismissable">
			                            <button type="button" class="close" data-dismiss="alert">
			                                <i class="ace-icon fa fa-times"></i>
			                            </button>
			                            <?php echo $this->session->flashdata('msg'); ?>
			                        </div>
								<?php endif ?>
							</div>
							<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
							

							<div class="position-relative" id="login-res">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header green lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												Điền thông tin đăng nhập
											</h4>

											<div class="space-6"></div>

											<?php echo form_open('', ['id'=>'login-form']); ?>
												<fieldset>
												<input type="hidden" name="access_token" value="<?= $ci_nonce; ?>">
													<label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input type="password" name="password" class="form-control" placeholder="Mật khẩu" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<label class="inline">
															<input type="checkbox" name="remember_me" class="ace" />
															<span class="lbl"> Nhớ đăng nhập</span>
														</label>

														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<span class="bigger-110">Đăng nhập</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											<?php echo form_close(); ?>

											<div class="social-or-login center">
												<span class="bigger-110">Hoặc đăng nhập với</span>
											</div>

											<div class="space-6"></div>

											<div class="social-login center">
												<a class="btn btn-primary facebook-login">
													<i class="ace-icon fa fa-facebook"></i>
												</a>
												<a class="btn btn-danger google-login">
													<i class="ace-icon fa fa-google-plus"></i>
												</a>
											</div>
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a href="#" data-target="#forgot-box" class="forgot-password-link">
													Quên mật khẩu
												</a>
											</div>

											<div class="text-center">
												<a href="mainpage">
													Trang Chủ
												</a>
											</div>

											<div>
												<a href="register" class="user-signup-link">
													Đăng ký mới
												</a>
											</div>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->
								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Đặt lại mật khẩu
											</h4>

											<div class="space-6"></div>
											<p>
												Nhập địa chỉ email để nhận đường dẫn thay đổi mật khẩu
											</p>

											<?php echo form_open('login/reset_password_request'); ?>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-left">
															<input type="email" name="email_address" class="form-control" placeholder="Email" required />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button type="submit" class="pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Gửi mã cho tôi!</span>
														</button>
													</div>
												</fieldset>
											<?php echo form_close(); ?>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a href="#" data-target="#login-box" class="back-to-login-link">
												Quay lại đăng nhập
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->
								
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
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
			 	$(document).on('click', '.toolbar a[data-target]', function(e) {
					e.preventDefault();
					var target = $(this).data('target');
					$('.widget-box.visible').removeClass('visible');//hide others
					$(target).addClass('visible');//show target
				 	
			 	});
			});
			
			// Facebook JS API setup
  			window.fbAsyncInit = function() {
  				FB.init({
				    appId      : '1412968472106511',
				    cookie     : true,  // enable cookies to allow the server to access 
				                        // the session
				    xfbml      : true,  // parse social plugins on this page
				    version    : 'v2.8' // use graph api version 2.8
  				});
  				
			};
			
			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/es_LA/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			jQuery('.facebook-login').click(function() {
				FB.login(function(response) {
				  	if (response.status === 'connected') {
		    			FB.api('/me?fields=name,email', function(response) {
			      			FB.api(
							    "/"+response.id+"/picture?height=150",
							    function (data) {
							      	if (data && !data.error) {
							        	/* handle the result */
						      			var user_data = {
						      				fullname 	: response.name,
						      				email 		: response.email,
						      				username 	: response.email,
						      				user_id 	: response.id,
						      				avatar 		: data.data.url
						      			};
						      			$.ajax({
						      				url: $('base').attr('href')+'login/login_with_social',
						      				type: 'POST',
						      				dataType: 'json',
						      				data: user_data
						      			})
						      			.done(function(data) {
						      				console.log(data);
						      				if (data.type == 'login_success') {
						      					window.location = $('base').attr('href')+'/profile/';
						      				}else{
						      					styling_after_login_with_social(data.new_uid);
						      				}

						      			});
							      	}
							    }
							);
		    			});
					} else {
					    // The person is not logged into this app or we are unable to tell. 
					}
				}, {scope: 'public_profile,email'});
			});


			jQuery(".google-login").click(function() {
				// Google JS API setup
				gapi.load('auth2', function() {
					auth2 = gapi.auth2.init({
					    client_id: '766757839775-ao74ir3qbsmtoibckg1icmq3d0duh3dm.apps.googleusercontent.com',
					    fetch_basic_profile: true,
					    scope: 'profile email openid'
					});

					// Sign the user in, and then retrieve their ID.
					
					auth2.signIn().then(function() {
					    if (auth2.isSignedIn.get()) {
							var profile = auth2.currentUser.get().getBasicProfile();
							var user_data = {
			      				fullname 	: profile.getFamilyName() + profile.getGivenName(),
			      				email 		: profile.getEmail(),
			      				username 	: profile.getEmail(),
			      				user_id 	: profile.getId(),
			      				avatar 		: profile.getImageUrl()
			      			};
			      			$.ajax({
			      				url: $('base').attr('href')+'login/login_with_social',
			      				type: 'POST',
			      				dataType: 'json',
			      				data: user_data
			      			})
			      			.done(function(data) {
			      				console.log(data);
			      				if (data.type == 'login_success') {
			      					window.location = $('base').attr('href')+'/profile/';
			      				}else{
			      					styling_after_login_with_social(data.new_uid);
			      				}

			      			});
						}
					});
				});
			});

			function styling_after_login_with_social($uid){
				var div = `
					<label class="block clearfix">Chọn kiểu người dùng: </label>
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
								<i class="ace-icon fa fa-graduation-cap"></i>
								<input type="text" name="student_id" id="student_id" class="form-control" placeholder="Mã số sinh viên">
							</span>
						</label>
						
					</div>
					<label class="block clearfix">
						<button type="submit" name="new_uid" class="pull-right btn btn-sm btn-primary" value="` +$uid+ `">
							<span class="bigger-110">Lưu thông tin</span>
						</button>
					</label>
				`;
				$('form#login-form fieldset').slideUp(400);
				$(".header.blue").text('Đăng ký thành công, vui lòng điền thêm thông tin phụ!');
				$('.widget-body .toolbar').remove();
				$('.widget-body .social-or-login').remove();
				$('.widget-body .social-login').remove();
				$('form#login-form fieldset').html(div).slideDown(400);
			}
		</script> 
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPMTQLm7omfoGI6tpH2AtNrL-_5aBdLsE&libraries=places" async defer></script>
   		
		<script type="text/javascript">
	    	function initAutoComplete(input){
	    		var autocomplete = new google.maps.places.Autocomplete(input);
	    	}
			jQuery(function($) {
				$("#login-box").on('change', '#user_typer',function() {
					$("#login-box .user_type_meta").slideUp(400);
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
				$('#login-box').on("change", "#company_id", function(){
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
