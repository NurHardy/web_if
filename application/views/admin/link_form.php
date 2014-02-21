<h2><?php if (isset($content_title)) echo $content_title; else echo "Tautan Baru"; ?></h2>
<div class='divclear'></div>
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
<hr>
<?php if (!isset($no_form)) { ?>
<form method='POST' action='<?php if (isset($form_action)) echo $form_action; else echo base_url('/admin/links/newlink'); ?>'>
	<div class='admin_form_item'>
		<div class='admin_form_label'><label class='lebar_unit' for='txt_name'>Nama Tautan</label></div>
		<div class='admin_form_field'><input class='f_txt_field' id='txt_name' type=text name='f_lnk_name' value='<?php if (isset($f_lnk_name)) echo $f_lnk_name; ?>' /></div>
		<div class='divclear'></div>
	</div>
	<div class='admin_form_item'>
		<div class='admin_form_label'><label class='lebar_unit' for='txt_url'>URL Tautan</label></div>
		<div class='admin_form_field'><input class='f_txt_field' id='txt_url' type=text name='f_lnk_url' value='<?php if (isset($f_lnk_url)) echo $f_lnk_url; ?>' style='width: 80%;'/><br>
			<small>Sertakan juga protokol link yang Anda tuju (http: atau https: atau ftp:)</small></div>
		<div class='divclear'></div>
	</div>
	<div class='unit'>
		<a href='<?php echo base_url('/admin/links'); ?>' class='button_admin btn_back'>&laquo; Batal</a>
		<input class='button_admin btn_save' type='submit' value='Simpan'>
	</div>
	
	<input type='hidden' name='form_submit' value='LINK_POST_FORM' />
</form>
<?php } // end if ?>