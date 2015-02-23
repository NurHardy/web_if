<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.form.min.js'); ?>"></script>
<script>
function initPopUpForm() {
	var options = {
		url: "<?php echo base_url("/admin/media/ajax"); ?>",
		beforeSubmit: function() {
			var fileName = $("#f_file").val();
			if (!fileName) {return false;}
		},
		beforeSend: function() 
		{
			// Disable dialog close..
			hide_form_cancel_button();
			$("#site_docs_doclist > .list_container").html("Uploading... Please wait...");
			checkItems();
			// Show progressbar
			$("#media_form_container").hide();
			$("#media_result").hide();
			$("#media_uploadprogress").show();
			// Clear everything
			$("#media_progressbar").width('0%');
			$("#media_progressnumb").html("0%");
		},
		uploadProgress: function(event, position, total, percentComplete) 
		{
			$("#media_progressbar").width(percentComplete+'%');
			$("#media_progressnumb").html(percentComplete+'%');
		},
		success: function() 
		{
			$("#media_progressbar").width('100%');
			$("#media_progressnumb").html('100%');
			$("#media_result").show();
			$("#media_result").html("Upload selesai. Sedang memproses foto... Silakan tunggu...");
		},
		complete: function(response) 
		{
			$("#media_result").html(response.responseText);
			$("#form_media_uploadmore").show();
			//refreshOnClose = true;
			loadDocumentList(0);
			show_form_cancel_button();
		},
		error: function()
		{
			show_form_cancel_button();
			$("#media_form_container").show();
			$("#media_uploadprogress").hide();
			$("#media_result").show();
			$("#media_result").html("<font color='red'> ERROR: unable to upload files</font>");
			$("#form_media_uploadmore").show();
		}
	};
	reshowForm();
	loadDocumentList(0);
	$("#media_form").ajaxForm(options);
}
function reshowForm() {
	$("#media_fileinput_container").html("<label for=\"f_file\">File</label>" +
		"<input type=\"file\" id=\"f_file\" name=\"f_files_[]\" onchange=\"onFileSelected();\"/>");
	$("#media_form_container").show();
	$("#media_uploadprogress").hide();
	$("#media_result").hide();
	$("#form_media_uploadmore").hide();
	return false;
}
function insertDocFormSubmit() {
	if (typeof(insertText)==='function') {
		var postData = $("#site_docs_selectform").serialize();
		postData += "&act=docs.select.getlink";
		$.ajax({
			type: "POST",
			url: ajaxPrefix+"/media/ajax",
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
	var len = $("#site_docs_doclist input[name='docs_id[]']:checked").length;
    if(len>0) {
		$('#site_docs_selectform button[type="submit"]').removeAttr('disabled');
		$("#site_docs_selectedinfo").text(len+' item terpilih.');
	} else {
		$('#site_docs_selectform button[type="submit"]').attr('disabled','disabled');
		$("#site_docs_selectedinfo").text('Tidak ada yang terpilih.');
	}
}
function onFileSelected() {
	$("#btn_media_submit").removeAttr('disabled');
}
function loadDocumentList(fileTypeIdFilter) {
	$.ajax({
		type: "POST",
		url: ajaxPrefix+"/media/ajax",
		data: {
			act: "docs.select.getlist",
			id: fileTypeIdFilter
		},
		beforeSend: function( xhr ) {
			checkItems();
			$("#site_docs_doclist > .list_loading").show();
			$("#site_docs_doclist > .list_container").hide();
		},
		success: function(response){
			$("#site_docs_doclist > .list_container").html(response);
		},
		error: function(xhr){
			$("#site_docs_doclist > .list_container").html("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
		}
	}).always(function() {
		$("#site_docs_doclist > .list_loading").hide();
		$("#site_docs_doclist > .list_container").show();
	});
}
</script>

<!-- Uploading interfaces -->
<div id='media_uploadprogress' class="site_box_info">
	<div id='media_progresstxt'>Terunggah <span id='media_progressnumb'>0%</span>. Silakan tunggu...</div>
	<div id='media_progressbox'>
		<div id='media_progressbar'></div>
	</div>
</div>
<div id='media_result'></div>
<div style="text-align: center; display: none;" id="form_media_uploadmore">
	<a href="#" onclick="return reshowForm();"><i class="site_icon-upload"></i> Unggah Dokumen Lain</a>
</div>

<!-- Main Interface -->
<fieldset>
	<legend>Pilih dokumen</legend>
	<div id="media_form_container">
		<!-- <div class="site_box_info">
			Ukuran maksimal tiap file: <b><?php
				if (isset($allowedMaxSize)) {
					$curUnit = "byte";
					$tmpSize = $allowedMaxSize;
					if ($tmpSize > 1024) {$curUnit = "kilobyte";$tmpSize /= 1024;}
					if ($tmpSize > 1024) {$curUnit = "megabyte";$tmpSize /= 1024;}
					$tmpSize = round($tmpSize, 2);
					echo $tmpSize." ".$curUnit.".";
				} else echo "unknown";
			?></b>,
			Format diperbolehkan: <b><?php
				if (isset($allowedExts)) {
					foreach ($allowedExts as $allowedTypeItem) {
						echo implode(", ", $allowedTypeItem).", ";
					}
				} else echo "-unknown-";
			?></b>
		</div> -->
		<form method="POST" action="#" enctype="multipart/form-data" id="media_form">
			<div id="media_fileinput_container" style="width: 500px; float: left; overflow: hidden;"></div>
			<div style="width: 100px; float: left;">
				<input class='button_admin btn_upload' type='submit' id='btn_media_submit' value='Unggah' disabled="disabled">
			</div>
			<input type="hidden" name="id" value="0" />
			<input type="hidden" name="act" value="docs.upload" />
		</form>
	</div>

	<div class='divclear'></div>
	<form action="#" method="post" onsubmit="return insertDocFormSubmit();" id="site_docs_selectform">
		<div id="site_docs_doclist">
			<div class="list_loading" style="display: none;" style="text-align: center;">Sedang memuat...<br>
				<img src='<?php echo base_url('/assets/images/loader.gif'); ?>' alt='Loading...' />
			</div>
			<div class="list_container">
				
			</div>
		</div>
		<span id="site_docs_selectedinfo"></span>
		<hr>
		<button type="submit" name="submit" value="true" class="button_admin" disabled="disabled">
			<i class="site_icon-right-open"></i> Sisipkan ke posting
		</button>
	</form>
</fieldset>