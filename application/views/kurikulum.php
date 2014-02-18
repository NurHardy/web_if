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
								echo "<tr  class='tb_row_3'><td width='5%' style='text-align:center;'>#</td><td>Mata kuliah</td><td width='10%'>SKS</td></tr>\n";
								$_matkulctr = 1;
								$_skstotal = 0;
								$_ctr_baris=0;
								foreach($matkul[$_ctr-1] as $_matkul) {
									if ($_ctr_baris %2 == 1) echo "<tr class='tb_row_3'>"; 
									else echo "<tr>";
									echo "<td width='5%' style='text-align:center;'>{$_matkulctr}</td><td><a href='/kurikulum/2012/{$_matkul->kodekul}'>{$_matkul->namakul}</a></td><td width='10%'>{$_matkul->sks}</td></tr>\n";
									$_matkulctr++;
									$_skstotal += $_matkul->sks;
									$_ctr_baris++;
								}
								echo "<tr><td colspan='2' style='font-weight: bold;'>Jumlah:</td><td width='10%'>{$_skstotal}</td></tr>\n";
								echo "</table>\n";
							}
							echo "\t\t</div>\n";
						}
						//Pada tabel mata kuliah pilihan kurikulum 2012, mata kuliah semester 11 = Ganjil, semester 12 = Genap
						echo "<h3>Kuliah Pilihan</h3>";
							echo "\t\t<div>";
							$_ctr = 11;
							if (count($matkul[$_ctr-1])==0) echo "Tidak ada record.";
							else{
									echo "<table>\n";
									echo "<tr  class='tb_row_3'><td width='5%' style='text-align:center;'>#</td><td>Mata kuliah</td><td width='10%'>Semester</td></tr>\n";
									$_matkulctr = 1;
									$_ctr_baris=0;
									foreach($matkul[$_ctr-1] as $_matkul) {
										if ($_ctr_baris %2 == 1) echo "<tr class='tb_row_3'>"; 
										else echo "<tr>";
										echo "<td width='5%' style='text-align:center;'>{$_matkulctr}</td><td><a href='/kurikulum/2012/{$_matkul->kodekul}'>{$_matkul->namakul}</a></td><td width='10%'>Genap</td></tr>\n";
										$_matkulctr++;
										$_ctr_baris++;
									}
									$_ctr++;
									foreach($matkul[$_ctr-1] as $_matkul) {
										if ($_ctr_baris %2 == 1) echo "<tr class='tb_row_3'>"; 
										else echo "<tr>";
										echo "<td width='5%' style='text-align:center;'>{$_matkulctr}</td><td><a href='/kurikulum/2012/{$_matkul->kodekul}'>{$_matkul->namakul}</a></td><td width='10%'>Ganjil</td></tr>\n";
										$_matkulctr++;
										$_ctr_baris++;
									}
									echo "</table>\n";
							}
							echo "\t\t</div>\n";
					?>
				</div>	
			</div>
			<div class="content tab_2">
				<div class="news_accordion">
					<?php
						for ($_ctr=1;$_ctr<=8;$_ctr++) {
							echo "\t\t<h3>Semester {$_ctr}</h3>\n";
							echo "\t\t<div>";
							if (count($matkul_2007[$_ctr-1])==0) echo "Tidak ada record.";
							else {
								echo "<table>\n";
								echo "<tr  class='tb_row_3'><td width='5%' style='text-align:center;'>#</td><td>Mata kuliah</td><td width='10%'>SKS</td></tr>\n";
								$_matkulctr = 1;
								$_skstotal = 0;
								$_ctr_baris=0;
								foreach($matkul_2007[$_ctr-1] as $_matkul_2007) {
									if ($_ctr_baris %2 == 1) echo "<tr class='tb_row_3'>"; 
									else echo "<tr>";
									echo "<td width='5%' style='text-align:center;'>{$_matkulctr}</td><td><a href='/kurikulum/2007/{$_matkul_2007->kodekul}'>{$_matkul_2007->namakul}</a></td><td width='10%'>{$_matkul_2007->sks}</td></tr>\n";
									$_matkulctr++;
									$_skstotal += $_matkul_2007->sks;
									$_ctr_baris++;
								}
								echo "<tr><td colspan='2' style='font-weight: bold;'>Jumlah:</td><td width='10%'>{$_skstotal}</td></tr>\n";
								echo "</table>\n";
							}
							echo "\t\t</div>\n";
						}
						//Pada kurikulum 2007, mata kuliah semester 11 = mata kuliah pilihan
						echo "<h3>Kuliah Pilihan</h3>";
							echo "\t\t<div>";
							$_ctr = 11;
							if (count($matkul_2007[$_ctr-1])==0) echo "Tidak ada record.";
							else{
									echo "<table>\n";
									echo "<tr  class='tb_row_3'><td width='5%' style='text-align:center;'>#</td><td>Mata kuliah</td><td width='10%'>Prasyarat</td></tr>\n";
									$_matkulctr = 1;
									//$_skstotal = 0;
									$_ctr_baris=0;
									foreach($matkul_2007[$_ctr-1] as $_matkul_2007) {
										if ($_ctr_baris %2 == 1) echo "<tr class='tb_row_3'>"; 
										else echo "<tr>";
										echo "<td width='5%' style='text-align:center;'>{$_matkulctr}</td><td><a href='/kurikulum/2007/{$_matkul_2007->kodekul}'>{$_matkul_2007->namakul}</a></td><td width='10%'>{$_matkul_2007->prasyarat}</td></tr>\n";
										$_matkulctr++;
										$_ctr_baris++;
									}
									echo "</table>\n";
							}
							echo "\t\t</div>\n";
					?>
				</div>
			</div>
		</div>
</div>