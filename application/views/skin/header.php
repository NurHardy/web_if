<!doctype HTML>
<!--
	We believe in come what may
	Informatics lead the way
	hiduplah Informatika....
-->
<html lang="id">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="<?php echo base_url('/assets/favicon.ico');?>" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="Author" content="Tim DIGIT Undip" />
	<meta name="Robots" content="index,follow" />
	
    <title><?php echo $page_title; ?> - Informatics UNDIP [Beta]</title>
	<?php if (isset($page_additional_head)) echo $page_additional_head; ?>
	
	<link href="<?php echo base_url('/assets/css/reset.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('/assets/css/global.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('/assets/css/diapo.css');?>" rel='stylesheet' type='text/css' media='all'>
	
	<script type='text/javascript' src="<?php echo base_url('/assets/js/jquery.min.js');?>"></script>
	<link type="text/css" href="<?php echo base_url('/assets/css/menu.css');?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url('/assets/css/tabs/general.css');?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url('/assets/css/tabs/tab.css');?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url('/assets/css/menushow.css');?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url('/assets/css/mobile_version.css');?>" rel="stylesheet" />
	<link type="text/css" href="<?php echo base_url('/assets/css/tablet_version.css');?>" rel="stylesheet" />
	
	<link type="application/rss+xml" rel="alternate" title="RSS Berita Jurusan Ilmu Komputer/Informatika UNDIP" href="<?php echo base_url('/feed');?>">
    
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen," />
	<![endif]-->
	<!-- link js tab-->
	<script type="text/javascript" src="<?php echo base_url('/assets/js/tabs.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('/assets/js/menu.js');?>"></script>
<?php if (isset($is_home)){?>
	<meta name="keywords" content="Informatika Undip, ilkom Undip, Teknik Informatika, Ilmu Komputer, Universitas Diponegoro, undip" >
	<meta name="description" content="Website resmi jurusan Teknik Informatika Universitas Diponegoro" />
	
	<!-- <script type='text/javascript' src='assets/js/jquery.mobile-1.0b2.min.js'></script> -->
	<script type='text/javascript' src='<?php echo base_url('/assets/js/jquery.easing.1.3.js');?>'></script> 
	<script type='text/javascript' src='<?php echo base_url('/assets/js/jquery.hoverIntent.minified.js');?>'></script> 
	<script type='text/javascript' src='<?php echo base_url('/assets/js/diapo.min.js');?>'></script>
	<script type='text/javascript' src='<?php echo base_url('/assets/js/menushow.js');?>'></script>
	<script>
	$(document).ready(function(){
		$(function(){
			$('.pix_diapo').diapo({
				autoAdvance: true,
				mobileAutoAdvance: true,
				mobileEasing: 'simpleFade',
				time: 5000,
				thumbs: false,
				loaderColor:"#31A1FF"
			});
		});
	});
	</script>
	<style>.readmore{display:none;}</style>
<?php } ?>
<script>
	$(document).ready(function(){
		$('#toggle_search').click(function(){
			$('.search_panel').slideToggle('fast');//you can give it a speed
		});
		$(".menu_mini").change(function() {
			var newurl = $(this).find("option:selected").val();
			if (newurl != '#') window.location = newurl;
		});
		(function() {
			var cx = '012334604403258577220:-xkdwekeoxc';
			var gcse = document.createElement('script');
			gcse.type = 'text/javascript';
			gcse.async = true;
			gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//www.google.com/cse/cse.js?cx=' + cx;
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(gcse, s);
		})();
	});
</script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/id_ID/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
<div id='site_main_wrapper' style='width: 100%;'>
<div id='site_wrapper'>
	<div id='site_bg_top' <?php if (isset($is_home)) echo "style='height: 330px;'"; ?>></div>
	<div id='site_header'>
		<div id='site_header_search'>
			<ul class='list_link_header'>
				<li class='first'><a href='<?php echo base_url('/page/sitemap');?>'><img class='site_header_but' src='<?php echo base_url('/assets/images/sitemap_icon.png');?>' alt='Sitemap' title='Sitemap' /></a></li>
				<li><a href='<?php echo base_url('/feed');?>'><img class='site_header_but' src='<?php echo base_url('/assets/images/rss_icon2.png');?>' alt='RSS' title='RSS Feed' /></a></li>
				<li><a href="javascript:void(0);" id="toggle_search"><img class='site_header_but' src='<?php echo base_url('/assets/images/search_icon.png');?>' alt='Cari' title='Cari' /></a></li>
			</ul>
			<div class='divclear'></div>
		</div>
		<div class='search_panel' style='display:none'>
			<!-- <gcse:search></gcse:search> -->
			<div class="gcse-search"  >
			</div>
		</div>
		<div id='site_header_logo'>
			<img src='<?php echo base_url('/assets/images/logo.png');?>' id='site_header_logoimg' alt='Logo' title='Jurusan Ilmu Komputer/Informatika Universitas Diponegoro'/>
		</div>
		<div class='divclear'></div>
	</div>
	<div id='site_navbar'>
		<div id='menu'>
			<?php include FCPATH.("/assets/menu.php"); ?>
		</div>
	</div>
	