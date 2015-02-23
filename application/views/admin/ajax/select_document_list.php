<?php
	foreach ($listDocument as $itemDocument) {
		$dateSubmit = strtotime($itemDocument->f_date_submit);
				
		$satuan = 'menit';
		$ts1 = $dateSubmit;
		$ts2 = strtotime(date('j F Y, H:i'));
		$t_diff = floor(abs($ts2 - $ts1)/60);
		if ($t_diff >= 60) {$t_diff = floor($t_diff / 60);$satuan = 'jam';}
		if ($t_diff >= 24) {$t_diff = floor($t_diff / 24);$satuan = 'hari';}
		if ($t_diff >= 30) {$t_diff = floor($t_diff / 30);$satuan = 'bulan';}
		else if ($t_diff >= 7) {$t_diff = floor($t_diff / 7);$satuan = 'minggu';}
		
		echo "<div><input type=\"checkbox\" name=\"docs_id[]\" onchange=\"checkItems();\"";
		echo " id=\"chk_file_".$itemDocument->f_id."\" value=\"".$itemDocument->f_id."\"/ >";
		echo " <label for=\"chk_file_".$itemDocument->f_id."\">";
		echo "<span class=\"site_docs_item\">";
		echo htmlspecialchars($itemDocument->f_name);
		echo "<span class=\"info\"> (diunggah ".$t_diff." ".$satuan." yang lalu)</span></span></label></div>\n";
	}
