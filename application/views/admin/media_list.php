<h2><i class="site_icon-list"></i> <?php if (isset($content_title)) echo $content_title; else echo "Daftar Media"; ?></h2>
<div>
	<h3>Media Teunggah</h3>
</div>
<!-- <a href='<?php echo base_url('/admin/media/newmedia'); ?>' class='button_admin btn_add'>Unggah baru &raquo;</a> -->
<a href='#' class='button_admin btn_add' onclick="return edit_album(-1);">Buat Album Baru</a>

<!-- <table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Media</td><td style='width: 200px;'>Action</td></tr> -->
<div><?php

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
			echo "<h2>".htmlspecialchars($categoryName)."</h2><hr>";
			$currentCat = $itemAlbum->id_category;
		}
		echo "<div class=\"admin_album_wrapper\">\n";
		
		$thumbUrl = (empty($itemAlbum->url_thumbnail)?"/assets/images/cover_small.png":$itemAlbum->url_thumbnail);
		$albumUrl = base_url("/admin/media/album/".$itemAlbum->id_album);
		
		if ($itemAlbum->status == 1)
			echo "<div class=\"site_box_success\"><i class=\"site_icon-globe\"></i> Published</div>";
		else
			echo "<div class=\"site_box_alert\"><i class=\"site_icon-lock\"></i> Hidden</div>";
			
		echo "<div class=\"admin_album_thumbnail\">\n";
		echo "<a href='".$albumUrl."'><img src='".base_url($thumbUrl)."'";
		echo " alt=\"".htmlspecialchars($itemAlbum->nama_album)."\"";
		echo " title=\"".htmlspecialchars($itemAlbum->nama_album)."\" />";
		echo "</a></div>\n";
		echo "<div class=\"admin_album_title\"><a href=\"".$albumUrl."\">".htmlspecialchars($itemAlbum->nama_album)."</a></div>\n";
		echo "<div class=\"admin_album_metadata\"><i class=\"site_icon-calendar\"></i> <b>".$itemAlbum->created.
				"</b><br><i class=\"site_icon-user\"></i> <b>".htmlspecialchars($itemAlbum->creator)."</b></div>\n";
		echo "<div class=\"admin_album_panel\"><a href=\"#\" onclick=\"return edit_album(".$itemAlbum->id_album.");\">\n";
		echo "		<i class=\"site_icon-pencil\"></i> Edit Album</a> | ";
		if ($itemAlbum->status == 1) {
			echo "	<a href=\"#\" onclick=\"return set_album_status(".$itemAlbum->id_album.", 0);\">\n";
			echo "		<i class=\"site_icon-lock\"></i> Unpublish Album</a>\n";
		} else {
			echo "	<a href=\"#\" onclick=\"return set_album_status(".$itemAlbum->id_album.", 1);\">\n";
			echo "		<i class=\"site_icon-globe\"></i> Publish Album</a>\n";
		}
		echo "	| <a href=\"#\" onclick=\"return delete_album(".$itemAlbum->id_album.");\">\n";
		echo "		<i class=\"site_icon-trash\"></i> Hapus Album</a>\n";
		
		echo "</div>";
		echo "</div>\n"; // End wrapper
		/*
		if (($_fctr%2)==0) echo "<tr class='tb_row_2'>";
		else echo "<tr>";
		echo "<td>{$_fctr}</td>";
		if ($_media->f_file_type_id == 1) {
			echo "<td><a href='".base_url($_media->f_file_path)."'><img src='".base_url($_media->f_file_path)."' alt='{$_media->f_name}' title='{$_media->f_name}'";
			echo " style='width: 200px; height: auto;' /></a>\n";
		} else {
			echo "<td><a href='".base_url($_media->f_file_path)."'>{$_media->f_name}</a>\n";
		}
		echo "<input type='text' readonly value='".htmlentities(base_url($_media->f_file_path))."' style='width: 100%;'/></td>";
		echo "<td><a href='#'><img src='".base_url('/assets/images/admin/admin_del.png')."' alt='Hapus' class='img_icon' title='Hapus'/></a></td>";
		echo "</tr>\n";
		$_fctr++;
		*/
	}
	?>
	<!-- </table> -->
	<div class="divclear"></div>
</div>
<script>
	function edit_album(albumId) {
		var formTitle = (albumId>0?"Edit Album":"New Album");
		show_form_overlay("media","album.getform", albumId, formTitle);
		return false;
	}
	function set_album_status(albumId, newStatus) {
		if (is_processing) return false;
		processed_id = albumId;
		
		var _act_ = "album.setstatus";
		_ajax_send("<?php echo base_url("/admin/media/ajax"); ?>", {
			act: _act_,
			id: albumId,
			status: newStatus
		}, 'Memproses...', function() {
			location.reload();
		}, true);
		return false;
	}
	function delete_album(albumId) {
		var formTitle = "Hapus Album";
		show_form_overlay("media","album.deleteform", albumId, formTitle);
		return false;
	}
</script>