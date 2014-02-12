<script type="text/javascript" >
$(document).ready(function(){
    $(".news_accordion h3:last").addClass("active");
    $(".news_accordion h3:first").addClass("noborder");
    $(".news_accordion div:not(:last)").hide();
    $(".news_accordion h3").hover(function(){ 
        $(".news_accordion h3").removeClass("active");
        $(this).toggleClass("active");
        $(this).next("div").slideToggle(0).siblings("div:visible").slideUp(250); 
    });
});
/*tab*/
$(function() {

			var $tabs = $('#tabs').tabs();
	
			$(".ui-tabs-panel").each(function(i){
	
			  var totalSize = $(".ui-tabs-panel").size() - 1;
	
			  if (i != totalSize) {
			      next = i + 2;
		   		  $(this).append("<a href='#' class='next-tab mover' rel='" + next + "'>Next Page &#187;</a>");
			  }
	  
			  if (i != 0) {
			      prev = i;
		   		  $(this).append("<a href='#' class='prev-tab mover' rel='" + prev + "'>&#171; Prev Page</a>");
			  }
   		
			});
	
			$('.next-tab, .prev-tab').click(function() { 
		           $tabs.tabs('select', $(this).attr("rel"));
		           return false;
		       });
       

		});
</script>
<div id='site_content_article'>
	<h2><?php echo $page_title?></h2>
		<div id="page-wrap">
		
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
							<!-- dan seterusnya -->
					</div>
				</div>
				<div id="fragment-2" class="ui-tabs-panel">
					<div class="news_accordion">
							<h3>Kurikulum 2012</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							
							<h3>Kurikulum 2013</h3>
							<div>Ringkasan berita<a href="#">more</a></div>
							<!-- dan seterusnya -->
					</div>
				</div>
			</div>
		</div>
</div>