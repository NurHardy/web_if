<script>

function initPopUpForm() {
	loadHome();
}
function insertPhotoFormSubmit() {
	if (typeof(insertText)==='function') {
		var postData = $("#site_photo_selectform").serialize();
		postData += "&act=photo.select.getlink";
		$.ajax({
			type: "POST",
			url: ajaxPrefix+"/media/select/ajax",
			data: postData,
			beforeSend: function( xhr ) {
				hide_form_cancel_button();
				$("#site_docs_doclist > .list_loading").show();
				$("#site_docs_doclist > .list_container").hide();
			},
			success: function(response){
				insertText(response);
				hide_form_overlay();
				$("#site_docs_doclist > .list_container").html();
			},
			error: function(xhr){
				$("#site_docs_doclist > .list_container").html("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
			}
		}).always(function() {
			show_form_cancel_button();
			$("#site_docs_doclist > .list_loading").hide();
			$("#site_docs_doclist > .list_container").show();
			checkItems();
		});
	}
	return false;
}
function checkItems() {
	var len = $("#site_photo_selectform input[name='photos_id[]']:checked").length;
    if(len>0) {
		$('#site_photo_selectform button[type="submit"]').removeAttr('disabled');
		$("#site_photo_selectedinfo").text(len+' item terpilih.');
	} else {
		$('#site_photo_selectform button[type="submit"]').attr('disabled','disabled');
		$("#site_photo_selectedinfo").text('Tidak ada yang terpilih.');
	}
}
function loadUploadForm(idAlbum) {
	
}
function loadAlbum(idAlbum) {
	$.ajax({
		type: "POST",
		url: ajaxPrefix+"/media/select/ajax",
		data: {
			act: "photo.select.getphoto",
			id: idAlbum
		},
		beforeSend: function( xhr ) {
			$("#admin_album_sel_loading").show();
			$("#admin_album_sel_list").hide();
		},
		success: function(response){
			$("#admin_album_sel_list").html(response);
			checkItems();
		},
		error: function(xhr){
			$("#admin_album_sel_list").html("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
		}
	}).always(function() {
		$("#admin_album_sel_loading").hide();
		$("#admin_album_sel_list").show();
	});
	return false;
}
function loadHome() {
	$.ajax({
		type: "POST",
		url: ajaxPrefix+"/media/select/ajax",
		data: {
			act: "photo.select.getalbum",
			id: -1
		},
		beforeSend: function( xhr ) {
			$("#admin_album_sel_loading").show();
			$("#admin_album_sel_list").hide();
		},
		success: function(response){
			$("#admin_album_sel_list").html(response);
			checkItems();
		},
		error: function(xhr){
			$("#admin_album_sel_list").html("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
		}
	}).always(function() {
		$("#admin_album_sel_loading").hide();
		$("#admin_album_sel_list").show();
	});
	return false;
}
</script>

<div>
	<div id="admin_album_sel_navigation">
		<a href="#" onclick="return loadHome();"><i class="site_icon-home"></i> Daftar Album</a> |
		<!-- <label for="admin_album_dropdown">Album:</label>
		<select id="admin_album_dropdown" name="site_album">
			<option>- Pilihan A -</option>
			<option>- Pilihan B -</option>
			<option>- Pilihan C -</option>
		</select> -->
	</div>
	<hr>
	<form action="#" onsubmit="return insertPhotoFormSubmit();" method="POST" id="site_photo_selectform">
		<div id="admin_album_sel_container">
			<div id="admin_album_sel_loading" style="display: none; text-align: center;">Sedang memuat...<br>
				<img src='<?php echo base_url('/assets/images/loader.gif'); ?>' alt='Loading...' />
			</div>
			<div id="admin_album_sel_list">
				
			</div>
		</div>
		<hr>
		<div id="site_photo_selectedinfo"></div>
		<button type="submit" name="submit" value="true" class="button_admin" disabled="disabled">
			<i class="site_icon-right-open"></i> Sisipkan ke posting
		</button>
	</form>
</div>