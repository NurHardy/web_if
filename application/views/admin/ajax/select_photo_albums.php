<?php

	$_fctr = 1;
	$currentCat = -1;
	$categoryName = "";

	foreach($listAlbum as $itemAlbum) {
		if ($currentCat != $itemAlbum->id_category) {
			if ($currentCat != -1)
				echo "<div class=\"divclear\"></div></div>\n";
			echo "<div style=\"padding: 10px;\">";
			
			if (array_key_exists($itemAlbum->id_category, $listCategory)) {
				$categoryName = $listCategory[$itemAlbum->id_category];
			} else
				$categoryName = "Unknown Category";
			echo "<h3>".htmlspecialchars($categoryName)."</h3><hr>";
			$currentCat = $itemAlbum->id_category;
		}
		echo "<div class=\"admin_album_wrapper_small\">\n";
		
		$thumbUrl = (empty($itemAlbum->url_thumbnail)?"/assets/images/cover_small.png":$itemAlbum->url_thumbnail);
		$albumOnClick = "return loadAlbum(".$itemAlbum->id_album.");";
			
		echo "<div class=\"admin_album_thumbnail\">\n";
		echo "<a href=\"#\" onclick=\"".$albumOnClick."\"><img src='".base_url($thumbUrl)."'";
		echo " alt=\"".htmlspecialchars($itemAlbum->nama_album)."\"";
		echo " title=\"".htmlspecialchars($itemAlbum->nama_album)."\" />";
		echo "</a></div>\n";
		echo "<div class=\"admin_album_title\"><a href=\"#\" onclick=\"".$albumOnClick."\">";
		echo htmlspecialchars($itemAlbum->nama_album)."</a></div>\n";
		echo "</div>\n"; // End wrapper
	}
