<div id='site_content_article'>
	<h2><?php echo $content_title?></h2>
	<?php
		if (empty($matkul_2007->kodekul)){
			echo "Maaf, data tidak ditemukan.";
			echo "<br>";
		}
		else{
			echo "<table>";
			echo "<tr><td width='20%'>Mata Kuliah</td><td>: {$matkul_2007->namakul}</td></tr>";
			echo "<tr><td width='20%'>Kode Mata kuliah</td><td>: {$matkul_2007->kodekul}</td></tr>";
			echo "<tr><td width='20%'>Jumlah SKS</td><td>: {$matkul_2007->sks}</td></tr>";
			echo "<tr><td width='20%'>Prasyarat</td><td>: {$matkul_2007->prasyarat}</td></tr>";
			echo "<tr><td width='20%'>Pustaka</td><td>: {$matkul_2007->pustaka}</td></tr>";
			echo "</table>";
		}
	?>
	<br>
	<a href='/kurikulum'>&laquo; Kembali</a>
</div>