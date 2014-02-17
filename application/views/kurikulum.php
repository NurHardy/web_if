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
		<div id="container">
			<ul class="menu_tab">
				<li id="tab_1" class="active">Kurikulum 2012</li>
				<li id="tab_2">Kurikulum 2007</li>
			</ul>
			<span class="clear"></span>
			<div class="content tab_1">
				<div class="news_accordion">
					<?php
						for ($_ctr=1;$_ctr<=8;$_ctr++) {
							echo "\t\t<h3>Semester {$_ctr}</h3>\n";
							echo "\t\t<div>";
							if (count($matkul[$_ctr-1])==0) echo "Tidak ada record.";
							else {
								echo "<table>\n";
								echo "<tr><td>#</td><td>Mata kuliah</td><td>SKS</td></tr>\n";
								$_matkulctr = 1;
								$_skstotal = 0;
								foreach($matkul[$_ctr-1] as $_matkul) {
									echo "<tr><td>{$_matkulctr}</td><td><a href='/kurikulum/2012/{$_matkul->kodekul}'>{$_matkul->namakul}</a></td><td>{$_matkul->sks}</td></tr>\n";
									$_matkulctr++;
									$_skstotal += $_matkul->sks;
								}
								echo "<tr><td colspan='2' style='font-weight: bold;'>Jumlah:</td><td>{$_skstotal}</td></tr>\n";
								echo "</table>\n";
							}
							echo "\t\t</div>\n";
						}
					?>
				</div>	
			</div>
			<div class="content tab_2">
				<div class="news_accordion">
						<h3>Semester 1</h3>
						<div><table>
							
						</table></div>
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