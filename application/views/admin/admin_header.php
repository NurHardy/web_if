<!doctype HTML>
<!-- CMS by DIGIT TEAM for Informatics UNDIP -->
<html lang="id">
	<head>
		<meta charset="utf-8">
		<title><?php echo $page_title; ?> - Informatics UNDIP CMS Administrator</title>
		
		<?php if (isset($page_additional_head)) echo $page_additional_head; ?>
		<link href="/assets/css/reset.css" rel="stylesheet" />
		<link href="/assets/css/global.css" rel="stylesheet" type="text/css" media="all" />
		<link href="/assets/css/menu.css" rel="stylesheet" type="text/css" media="all" />
		<link href="/assets/css/admin.css" rel="stylesheet" type="text/css" media="all" />
		<script type='text/javascript' src='/assets/js/jquery.min.js'></script>
	</head>
	<body>
<?php if (!isset($no_bodyhead)) { ?>
		<div id='admin_wrapper'>
			<div id="admin_head_parent">
				<div id="admin_head_center">
					<img src='/assets/images/logo.png' id='logo_' alt='Logo' title='Ilmu Komputer/Informatika UNDIP'/>
					<!-- <span style="color: #fff;"><p>Selamat datang, <?php echo $username_; ?></p></span> -->
					<div id='admin_menu'>
						<div id="menu">
							<ul class="menu">
								<li><a href="/" class="parent"><span>Home</span></a></li>
								<li><a href='/admin/dashboard' class='parent'><span>Dasbor</span></a></li>
								<li><a href='/admin/auth/logout' class='parent'><span>Logout</span></a></li>
							</ul>
						</div>
					</div>
					<div class='divclear'></div>
				</div>
			</div><?php } // end if ?>
		<div id="admin_content">