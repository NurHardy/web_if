<h2><?php if (isset($content_title)) echo $content_title; else echo "Pengumuman Baru"; ?></h2>
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
<form method='POST' action='<?php if (isset($form_action)) echo $form_action; else echo base_url('/admin/pengumuman/newpengumuman'); ?>'>
	<table>
		<tr><td width='150px'>Judul</td><td><input class='f_txt_field' style='width:80%' id='txt_name' type=text name='judul' value='<?php if (isset($judul)) echo $judul; ?>' />&nbsp*</td></tr>
		<tr><td width='150px'>Tanggal berakhir</td><td><input class='f_txt_field' style='width:20%' id='txt_name' type=text name='tgl_akhir' value='<?php if (isset($tgl_akhir)) echo $tgl_akhir; ?>' /><small>&nbspformat(YYYYMMDD)*</small></td></tr>
		<tr><td colspan=2>Isi Pengumuman &nbsp*</td></tr>
		<tr><td colspan=2><textarea style='width:84% ;min-height:200px' name='isi'><?php if (isset($isi)) echo $isi; ?></textarea></td></tr>
		<tr><td colspan=2><small>* wajib diisi</small></td></tr>
		<tr><td colspan=2><small>* simpan jika ada perubahan</small></td></tr>
	</table>
	<div class='divclear'></div>
	<div class='unit'>
		<a href='<?php echo base_url('/admin/pengumuman'); ?>' class='button_admin btn_back'>&laquo; Batal</a>
		<input class='button_admin btn_save' type='submit' value='Simpan'>
	</div>
	
	<input type='hidden' name='form_submit' value='LINK_POST_FORM' />
</form>
<?php } // end if ?>