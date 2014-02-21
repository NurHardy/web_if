<!doctype HTML>
<!-- CMS by DIGIT TEAM for Informatics UNDIP -->
<html lang="id">
	<head>
		<meta charset="utf-8">
		<title><?php echo $page_title; ?> - Informatics UNDIP CMS Administrator</title>
		<link rel="icon" href="<?php echo base_url('/assets/admin.ico'); ?>" type="image/x-icon">
		<?php if (isset($page_additional_head)) echo $page_additional_head; ?>
		<link href="<?php echo base_url('/assets/css/reset.css'); ?>" rel="stylesheet" /> 
		<link href="<?php echo base_url('/assets/css/global.css'); ?>" rel="stylesheet" type="text/css" media="all" />
		<link href="<?php echo base_url('/assets/css/menu.css'); ?>" rel="stylesheet" type="text/css" media="all" />
		<link href="<?php echo base_url('/assets/css/admin.css'); ?>" rel="stylesheet" type="text/css" media="all" />
		<script type='text/javascript' src='<?php echo base_url('/assets/js/jquery.min.js'); ?>'></script>
	</head>
	<body>
<?php if (!isset($no_bodyhead)) { ?>
		<div id='admin_wrapper'>
			<div id="admin_head_parent">
				<div id="admin_head_center">
					<img src='<?php echo base_url('/assets/images/logo.png'); ?>' id='logo_' alt='Logo' title='Ilmu Komputer/Informatika UNDIP'/>
					<!-- <span style="color: #fff;"><p>Selamat datang, <?php echo $username_; ?></p></span> -->
					<div id='admin_menu'>
						<div id="menu">
							<ul class="menu">
								<li><a href="<?php echo base_url('/'); ?>" class="parent"><span>Home</span></a></li>
								<li><a href='<?php echo base_url('/admin/dashboard'); ?>' class='parent'><span>Dasbor</span></a></li>
								<li><a href='<?php echo base_url('/admin/auth/logout'); ?>' class='parent'><span>Logout</span></a></li>
							</ul>
						</div>
					</div>
					<div class='divclear'></div>
				</div>
			</div><?php } // end if ?>
		<div id="admin_content">