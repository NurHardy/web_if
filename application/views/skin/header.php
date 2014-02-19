<!doctype HTML>
<!--
	We believe in come what may
	Informatics lead the way
	hiduplah Informatika....
-->
<html lang="id">
<head>
	<meta charset="utf-8">
	<link rel="icon" href="/assets/favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	
    <title><?php echo $page_title; ?> - Informatics UNDIP [Alpha]</title>
	<?php if (isset($page_additional_head)) echo $page_additional_head; ?>
	
	<link href="/assets/css/reset.css" rel="stylesheet">
	<link href="/assets/css/global.css" rel="stylesheet">
	<link href='/assets/css/diapo.css' rel='stylesheet' type='text/css' media='all'>
	
	<script type='text/javascript' src='/assets/js/jquery.min.js'></script>
	<link type="text/css" href="/assets/css/menu.css" rel="stylesheet" />
	<link type="text/css" href="/assets/css/tabs/general.css" rel="stylesheet" />
	<link type="text/css" href="/assets/css/tabs/tab.css" rel="stylesheet" />
	<link type="text/css" href="/assets/css/menushow.css" rel="stylesheet" />
	<link type="text/css" href="/assets/css/mobile_version.css" rel="stylesheet" />
	<link type="text/css" href="/assets/css/tablet_version.css" rel="stylesheet" />
	
	<link type="application/rss+xml" rel="alternate" title="RSS Berita Jurusan Ilmu Komputer/Informatika UNDIP" href="/feed">
    
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="screen," />
	<![endif]-->
	<!-- link js tab-->
	<script type="text/javascript" src="/assets/js/tabs.js"></script>
	<script type="text/javascript" src="/assets/js/menu.js"></script>
<?php if (isset($is_home)){?>
	
	<!-- <script type='text/javascript' src='assets/js/jquery.mobile-1.0b2.min.js'></script> -->
	<script type='text/javascript' src='/assets/js/jquery.easing.1.3.js'></script> 
	<script type='text/javascript' src='/assets/js/jquery.hoverIntent.minified.js'></script> 
	<script type='text/javascript' src='/assets/js/diapo.min.js'></script>
	<script type='text/javascript' src='/assets/js/menushow.js'></script>
	<script>
	$(document).ready(function(){
		$(function(){
			$('.pix_diapo').diapo({
				autoAdvance: true,
				mobileAutoAdvance: true,
				mobileEasing: 'simpleFade',
				thumbs: false,
				loaderColor:"#31A1FF"});
		});
		$('#toggle_search').click(function(){
			$('.search_panel').slideToggle();//you can give it a speed
		  });
	});
	</script>
	<style>.readmore{display:none;}</style>
<?php } ?>
<script>
	$(document).ready(function(){
		$(".menu_mini").change(function() {
			var newurl = $(this).find("option:selected").val();
			if (newurl != '#') window.location = newurl;
		});
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

//google search custome
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
//menu
$(document).ready(function(){
  
  
  /*$('li.mainlevel').mouseleave(function(){
  $(this).find('ul').slideUp("fast");
  });*/
  
});
</script>
<div id='site_main_wrapper' style='width: 100%;'>
<div id='site_wrapper'>
	<div id='site_bg_top' <?php if (isset($is_home)) echo "style='height: 330px;'"; ?>></div>
	<div id='site_header'>
		<div id='site_header_search'>
			<ul class='list_link_header'>
				<li class='first'><a href='#'><img class='search_but' src='/assets/images/sitemap_icon.png'></a></li>
				<li><a href='/feed'><img class='search_but' src='/assets/images/rss_icon2.png'></a></li>
				<li><a href="#" id="toggle_search"><img class='search_but' src='/assets/images/search_icon.png'></a>
					<ul class='search_panel'>
						<li class='last'><gcse:search></gcse:search></li>
					</ul>
				</li>
			</ul>
			<!--<div class='search_button'style='width:100px;height:20px'></div>
			<div class='search_panel'><gcse:search></gcse:search></div>-->
		</div>
		<div class='divclear'></div>
		<div id='site_header_logo'>
			<img src='/assets/images/logo.png' id='site_header_logoimg' alt='Logo' title='Jurusan Ilmu Komputer/Informatika Universitas Diponegoro'/>
		</div>
		<div class='divclear'></div>
	</div>
	<div id='site_navbar'>
		<div id='menu'>
			<?php include FCPATH."/assets/menu.php"; ?>
		</div>
	</div>
	