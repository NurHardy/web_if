<!doctype HTML>
<!-- CMS by DIGIT TEAM for Informatics UNDIP -->
<html lang="id">
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="noindex,nofollow" />
		<title><?php echo $page_title; ?> - Informatics UNDIP CMS Administrator</title>
		<link rel="icon" href="<?php echo base_url('/assets/admin.ico'); ?>" type="image/x-icon">
		<?php if (isset($page_additional_head)) echo $page_additional_head; ?>
		<link href="<?php echo base_url('/assets/css/reset.css'); ?>" rel="stylesheet" /> 
		<link href="<?php echo base_url('/assets/css/global.css'); ?>" rel="stylesheet" type="text/css" media="all" />
		<link href="<?php echo base_url('/assets/css/menu.css'); ?>" rel="stylesheet" type="text/css" media="all" />
		<link href="<?php echo base_url('/assets/css/admin.css'); ?>" rel="stylesheet" type="text/css" media="all" />
		<script type='text/javascript' src='<?php echo base_url('/assets/js/jquery.min.js'); ?>'></script>
		<script>
		var _refresh = false;
		var __need_refresh = false;
		var is_processing = false;
		var processed_id = 0;
		var _ov_msg;
		
		function show_overlay(_msg) {
			if (_msg === '') {$("#admin_ov_msg").html('Sedang memproses... Mohon tunggu...');}
			else $("#admin_ov_msg").html(_msg);
			$("#admin_overlay").show();
		}
		function hide_overlay() {
			$("#admin_overlay").fadeOut(100);
		}
		function ov_change_msg(_msg) {
			$("#admin_ov_msg").html(_msg);
		}
		function _ajax_send(_requesturl, _postdata, _msg, _finishcallback, _needrefresh) {
			_ov_msg = _msg || 'Menyimpan...';
			__need_refresh = _needrefresh || false;
			_refresh = false;
			var _reqURL = _requesturl || "<?php echo base_url('/admin/system/ajax'); ?>";
			$.ajax({
				type: "POST",
				url: _reqURL,
				data: _postdata,
				beforeSend: function( xhr ) {
					is_processing = true;
					show_overlay(_ov_msg);
				},
				success: function(response){
					var result = $.trim(response);
					if(result === "OK") {
						if (__need_refresh) {
							_refresh = __need_refresh;
							ov_change_msg("Me-<i>reload</i> halaman...");
						}
						_finishcallback();
					} else {
						alert('Operasi gagal: '+result);
					}
				},
				error: function(xhr){
					alert("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
				}
			}).always(function() {
				is_processing = false;
				if (!_refresh) hide_overlay();
			});
		}
		function refreshPage(ov_msg) {
			is_processing = true;
			show_overlay(ov_msg);
			location.reload();
		}
		</script>
	</head>
	<body>
		<div id='admin_overlay'>
			<div id='admin_ov_box'>
				<div id='admin_ov_msg'>Sedang memproses... Mohon tunggu...</div>
				<img src='<?php echo base_url('/assets/images/loader.gif'); ?>' alt='Loading...' />
			</div>
		</div>
<?php if (!isset($no_bodyhead)) { ?>
		<div id='admin_wrapper'>
			<div id="admin_head_parent">
				<div id="admin_head_center">
					<img src='<?php echo base_url('/assets/images/logo.png'); ?>' id='logo_' alt='Logo' title='Ilmu Komputer/Informatika UNDIP'/>
					<span id='admin_logininfo'><p>Masuk sebagai <b><?php echo $this->nativesession->get('user_name_'); ?></b></p></span>
					<div id='admin_menu'>
						<div id="menu">
							<ul class="menu">
								<li><a href="<?php echo base_url('/'); ?>" class="parent" target="_blank"><span>
										<i class="site_icon-home"></i> Home
									</span></a></li>
								<!-- <li><a href='<?php echo base_url('/admin/dashboard'); ?>' class='parent'><span>
										<i class="site_icon-gauge"></i> Dasbor
									</span></a></li> -->
								<li><a href='<?php echo base_url('/admin/auth/logout'); ?>' class='parent'><span>
										<i class="site_icon-power"></i> Logout
									</span></a></li>
							</ul>
						</div>
					</div>
					<div class='divclear'></div>
				</div>
			</div><?php } // end if ?>
		<div id="admin_content">