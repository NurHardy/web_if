<?php
	if (!empty($errors)) {
		$info_ = '<div class="errormsgbox"><ol>';
        foreach ($errors as $key => $values) {
            $info_ .= '	<li>'.$values."</li>\n";
        }
        $info_ .= '</ol></div>';
		echo $info_;
	}
	if (!empty($infos)) {
		$info_ = '<div class="success"><ol>';
        foreach ($infos as $key => $values) {
            $info_ .= '	<li>'.$values."</li>\n";
        }
        $info_ .= '</ol></div>';
		echo $info_;
	}
?>
<div>
	<h2>Unggah Media</h2>
</div>
<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.form.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('/assets/js/admin_media.js'); ?>"></script>
	<form method=POST action='<?php echo base_url('/admin/media/upload'); ?>' id ='media_form' enctype="multipart/form-data">
		<div class='unit'><label class='lebar_unit' for='f_file'>File</label><input type="file" id='f_file' multiple name="f_files_[]" /></div>
		<div class='unit'><input class='button_admin btn_upload' type='submit' id='btn_media_submit' value='Unggah'> </div>
		<input type='hidden' name='form_submit' value='MEDIA_POST_FORM' />
	</form>

<div class='divclear'></div>
<div id='media_uploadprogress'>
	<div id='media_progresstxt'>Terunggah <span id='media_progressnumb'>0%</span>. Silakan tunggu...</div>
	<div id='media_progressbox'>
		<div id='media_progressbar'></div>
	</div>
</div>
<div id='media_result'></div>
