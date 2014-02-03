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
<script type="text/javascript" src="/assets/js/jquery.form.min.js"></script>
<script type="text/javascript" src="/assets/js/admin_media.js"></script>
	<div>Maaf, masih dalam pengembangan. Belum bisa digunakan...</div>
	
	<form method=POST action='/admin/uploadmedia' id ='media_form'>
		<div class='unit'><label class='lebar_unit' for='f_file'>File</label><input type="file" id='f_file' multiple name="f_files_[]" /></div>
		<div class='unit'><input class='button_admin' type='submit' id='btn_media_submit' value='Unggah'> </div>
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
