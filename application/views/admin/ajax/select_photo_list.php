<?php

	$_fctr = 1;
	$currentCat = -1;
	$categoryName = "";

	foreach($listPhoto as $itemPhoto) {
		$thumbUrl = (empty($itemPhoto->url_thumbnail)?$itemPhoto->url_foto:$itemPhoto->url_thumbnail);
		$checkBoxId = "photo_".$itemPhoto->id_foto;
		
		echo "<div class=\"admin_album_wrapper_small\">\n";
		echo "<div><input type=\"checkbox\" name=\"photos_id[]\" id=\"".$checkBoxId."\" onchange=\"checkItems();\" ";
		echo "value=\"".$itemPhoto->id_foto."\"/></div>";
		echo "<div class=\"admin_album_thumbnail\">\n";
		echo "<label for=\"".$checkBoxId."\"><img src='".base_url($thumbUrl)."'";
		echo " alt=\"".htmlspecialchars($itemPhoto->nama_album)."\"";
		echo " title=\"".htmlspecialchars($itemPhoto->nama_album)."\" />";
		echo "</label></div>\n";
		echo "<div class=\"admin_album_title\">".htmlspecialchars($itemPhoto->nama_album)."</div>\n";
		echo "</div>\n"; // End wrapper
	}
