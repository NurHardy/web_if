<!doctype HTML>
<html>
<head>
    <title><?php echo $page_title; ?> - Informatics UNDIP [Alpha]</title>
	<?php if (isset($page_additional_head)) echo $page_additional_head; ?>
	
	<link href="assets/css/reset.css" rel="stylesheet">
	<link href="assets/css/global.css" rel="stylesheet">
	<link href='assets/css/diapo.css' rel='stylesheet' type='text/css' media='all'>
	
	<script type='text/javascript' src='assets/js/jquery.min.js'></script>
	<!-- <script type='text/javascript' src='assets/js/jquery.mobile-1.0b2.min.js'></script> -->
	<script type='text/javascript' src='assets/js/jquery.easing.1.3.js'></script> 
	<script type='text/javascript' src='assets/js/jquery.hoverIntent.minified.js'></script> 
	<script type='text/javascript' src='assets/js/diapo.min.js'></script>
	<link type="text/css" href="assets/css/menu.css" rel="stylesheet" />
	<link type="text/css" href="assets/css/tabs/general.css" rel="stylesheet" />
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen," />
	<![endif]-->
	<!-- link js tab-->
	<script type="text/javascript" src="assets/js/tabs.js"></script>
	<script>
		$(function(){
			$('.pix_diapo').diapo({
				autoAdvance: true,
				mobileAutoAdvance: true,
				mobileEasing: 'simpleFade',
				thumbs: false,
				loaderColor:"#31A1FF"});
		});

		</script>
		<style>.readmore{display:none;}</style>
</head>
<body>
<div id='site_wrapper'>
	<div id='site_bg_top' style='height: 350px;'></div>
	<div id='site_bg_'></div>
	<div id='site_header'>
		<div id='site_header_search'></div>
		<div class='divclear'></div>
		<div id='site_header_logo'>
			<img src='assets/images/logo.png' id='site_header_logoimg' />
		</div>
		<div class='divclear'></div>
	</div>
	<div id='site_navbar'>
		<div id='menu'>
			<?php include FCPATH."/assets/menu.php"; ?>
		</div>
	</div>
	