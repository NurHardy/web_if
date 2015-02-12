<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.form.min.js'); ?>"></script>
<script>
function initPopUpForm() {
	var options = {
		url: "<?php echo base_url("/admin/media/ajax"); ?>",
		beforeSubmit: function() {
			var fileName = $("#f_file").val();
			if (!fileName) {
				return false;
			}
		},
		beforeSend: function() 
		{
			$("#media_form").hide();
			$("#media_result").hide();
			$("#media_uploadprogress").show();
			//clear everything
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
			refreshOnClose = true;
		},
		error: function()
		{
			$("#media_form").show();
			$("#media_uploadprogress").hide();
			$("#media_result").show();
			$("#media_result").html("<font color='red'> ERROR: unable to upload files</font>");
			$("#form_media_uploadmore").show();
		}
	};
	reshowForm();
	$("#media_form").ajaxForm(options);
}
function reshowForm() {
	$("#media_fileinput_container").html("<label for=\"f_file\">File</label>" +
		"<input type=\"file\" id=\"f_file\" multiple name=\"f_files_[]\" />");
	$("#media_form").show();
	$("#media_uploadprogress").hide();
	$("#media_result").hide();
	$("#form_media_uploadmore").hide();
	return false;
}
</script>
<div style="width: 400px; margin: 0 auto; text-align: center; margin-top: 20px;" id="media_form">
	<div class="site_box_info">
		Ukuran maksimal tiap file: <b><?php
			if (isset($allowedMaxSize)) {
				$curUnit = "byte";
				$tmpSize = $allowedMaxSize;
				if ($tmpSize > 1024) {$curUnit = "kilobyte";$tmpSize /= 1024;}
				if ($tmpSize > 1024) {$curUnit = "megabyte";$tmpSize /= 1024;}
				$tmpSize = round($tmpSize, 2);
				echo $tmpSize." ".$curUnit.".";
			} else echo "unknown";
		?></b><br>
		Format diperbolehkan: <b><?php
			if (isset($allowedExts)) {
				foreach ($allowedExts as $allowedTypeItem) {
					echo implode(", ", $allowedTypeItem).", ";
				}
			} else echo "-unknown-";
		?></b>
	</div>
	<form method="POST" action="#" enctype="multipart/form-data">
		<div>Unggah dokumen baru.</div>
		<div id="media_fileinput_container"></div>
		<div><input class='button_admin btn_upload' type='submit' id='btn_media_submit' value='Unggah'></div>
		<input type="hidden" name="id" value="0" />
		<input type="hidden" name="act" value="docs.upload" />
	</form>
</div>

<div class='divclear'></div>
<div id='media_uploadprogress' class="site_box_info">
	<div id='media_progresstxt'>Terunggah <span id='media_progressnumb'>0%</span>. Silakan tunggu...</div>
	<div id='media_progressbox'>
		<div id='media_progressbar'></div>
	</div>
</div>
<div id='media_result'></div>
<div style="text-align: center; display: none;" id="form_media_uploadmore">
	<a href="#" onclick="return reshowForm();"><i class="site_icon-upload"></i> Unggah Dokumen Lagi</a>
</div>