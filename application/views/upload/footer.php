	<div class="footer">
		<div class="footer-inner">
			<div class="footer-content">
				<span class="bigger-120">
					<span class="blue bolder">Upload Image</span>
					Application &copy; 2013-2014
				</span>

				&nbsp; &nbsp;
				<span class="action-buttons">
					<a href="#">
						<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
					</a>

					<a href="#">
						<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
					</a>

					<a href="#">
						<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
					</a>
				</span>
			</div>
		</div>
	</div>

	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
<script src="assets/js/jquery-2.1.4.min.js"></script>
<!--[if IE]>
	<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="assets/js/jquery-ui.custom.min.js"></script>
<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
<!-- <script src="assets/js/chosen.jquery.min.js"></script> -->
<script src="assets/js/bootstrap-tag.min.js"></script>
<script src="assets/js/dropzone.min.js"></script>
<!-- ace scripts -->
<script src="assets/js/ace-elements.min.js"></script>
<script src="assets/js/ace.min.js"></script>
<script src="assets/js/jquery-typeahead.js"></script>
<script>
	jQuery(document).ready(function($) {
		<?php if ($this->session->has_userdata('keywords')): ?>
			var keys = "<?= $this->session->keywords ?>";
			keys = keys.replace(/ /g,'');
			if (keys != '' && keys != ' ') {
				$("#search-tags").val(keys);
			}
		<?php endif; ?>
	});
</script>
<script src="assets/js/upload.js"></script>
</body>
</html>
