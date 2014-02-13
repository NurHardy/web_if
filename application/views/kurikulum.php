<script type="text/javascript" >
$(document).ready(function(){
    //$(".news_accordion h3:last").addClass("active");
    $(".news_accordion h3:first").addClass("noborder");
    $(".news_accordion div").hide();
    $(".news_accordion h3").click(function(){ 
        $(".news_accordion h3").removeClass("active");
        $(this).toggleClass("active");
        $(this).next("div").slideToggle('fast').siblings("div:visible").slideUp('fast'); 
    });
});
</script>
<div id='site_content_article'>
	<h2><?php echo $page_title?></h2>
		<!--<div id="page-wrap">
		
			<div id="tabs">
			
				<ul>
					<li><a href="#fragment-1">Kurikulum 2012</a></li>
					<li><a href="#fragment-2">Kurikulum 2013</a></li>
				</ul>
				<div id="fragment-1" class="ui-tabs-panel">
					<div class="news_accordion">
							<h3>Semester 1</h3>
							<table>
								
							</table>
							
							<h3>Semester 2</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 3</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 4</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 5</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 6</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 7</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 8</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
					</div>
				</div>
				<div id="fragment-2" class="ui-tabs-panel">
					<div class="news_accordion">
							<h3>Kurikulum 2012</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Kurikulum 2013</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
					</div>
				</div>
			</div>
		</div> -->
		<div id="container">
			<ul class="menu_tab">
				<li id="tab_1" class="active">Kurikulum 2007</li>
				<li id="tab_2">Kurikulum 2013</li>
			</ul>
			<span class="clear"></span>
			<div class="content tab_1">
				<div class="news_accordion">
							<h3>Semester 1</h3>
<<<<<<< HEAD
							<div><table>
								
							</table>
							</div>
							
=======
							<table>
								
							</table>
>>>>>>> a70649b6e19129ce21a28eccc1280c31117d0993
							
							<h3>Semester 2</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 3</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 4</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 5</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 6</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 7</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 8</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
					</div>
				</div>
			<div class="content tab_2">
				<div class="news_accordion">
							<h3>Semester 1</h3>
<<<<<<< HEAD
							<div>
							<table>
								
							</table></div>
=======
							<table>
								
							</table>
>>>>>>> a70649b6e19129ce21a28eccc1280c31117d0993
							
							<h3>Semester 2</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 3</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 4</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 5</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 6</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 7</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Semester 8</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
					</div>
				</div>
		</div>
</div>