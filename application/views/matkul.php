<div id='site_content_article'>
	<h2><?php echo $content_title; ?></h2>
	<?php
		if (empty($matkul->kodekul)){
			echo "Maaf, data tidak ditemukan.";
			echo "<br>";
		}
		else{
			echo "<table>";
			echo "<tr><td width='20%'>Mata Kuliah</td><td>: {$matkul->namakul}</td></tr>";
			echo "<tr><td width='20%'>Kode Mata kuliah</td><td>: {$matkul->kodekul}</td></tr>";
			echo "<tr><td width='20%'>Jumlah SKS</td><td>: {$matkul->sks}</td></tr>";
			echo "<tr><td width='20%'>Prasyarat</td><td>: {$matkul->prasyarat}</td></tr>";
			echo "<tr><td width='20%'>Pustaka</td><td>: {$matkul->pustaka}</td></tr>";
			echo "</table>";
		}
	?>
	<br>
	<a href='<?php echo base_url("/kurikulum"); ?>'>&laquo; Kembali</a>
</div>