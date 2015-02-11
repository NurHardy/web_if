<h2>Album <?php echo htmlspecialchars($dataAlbum->nama_album); ?></h2>
<div>
	<a href="<?php echo base_url("/admin/media"); ?>">
		<i class="site_icon-left-open"></i> Kembali ke daftar Album
	</a> | <a href='#' class='button_admin btn_add' onclick="return new_photo();">Unggah Foto Baru</a>
</div>

<div class="admin_album_body"><?php

	$_fctr = 1;
	$currentCat = -1;
	$categoryName = "";

	foreach($listPhoto as $itemPhoto) {
		$thumbUrl = (empty($itemPhoto->url_thumbnail)?"/assets/images/cover_small.png":$itemPhoto->url_thumbnail);
		
		echo "<div style=\"float: left; text-align: center; width: 150px; height: 150px; background-color: #eee; margin: 5px; padding: 5px; overflow: hidden;\">\n";
		echo "<a href='#' onclick=\"return view_photo(".$itemPhoto->id_foto.");\"><img src='".base_url($thumbUrl)."'";
		echo " alt='{$itemPhoto->filename}' title='{$itemPhoto->filename}'";
		echo " style='height: 100%; width: auto;' /><br>";
		echo htmlspecialchars($itemPhoto->filename);
		echo "</a>\n";
		echo "</div>\n";
	}
	?>
	<div class="divclear"></div>
</div>
<script>
	var albumId = <?php echo $dataAlbum->id_album; ?>;
	function new_photo() {
		var formTitle = "Unggah Foto Baru";
		show_form_overlay("media","photo.getform", albumId, formTitle);
		return false;
	}
	function view_photo(photoId) {
		var formTitle = "Detil Foto Galeri";
		show_form_overlay("media","photo.getdetail", photoId, formTitle);
		return false;
	}
	function link_form_submit() {
		if (is_processing) return false;
		processed_id = -1;
		var formdata = $("#admin_form_link").serialize();
		
		_ajax_send(formdata, function() {
			hide_form_overlay();
			location.reload();
		}, 'Mengirimkan Data', true);
		return false;
	}
	function link_delete(_id) {
		if (is_processing) return false;
		
		var _conf = confirm("Hapus item yang Anda pilih?");
		if (_conf == false) return false;
		processed_id = _id;
		
		var _act_ = "links.delete";
		_ajax_send({
			act: _act_,
			id: _id
		}, function() {
			location.reload();
		}, 'Memproses...', true);
		return false;
	}
</script>