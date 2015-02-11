<h2><?php if (isset($content_title)) echo $content_title; else echo "Staff Baru"; ?></h2>
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
<form method='POST' action='<?php if (isset($form_action)) echo $form_action; else echo base_url('/admin/staff/newstaff'); ?>'>
	<table>
		<tr><td width='150px'>Nama</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='nama' value='<?php if (isset($nama)) echo $nama; ?>' />&nbsp*</td></tr>
		<tr><td>NIP</td><td><input class='f_txt_field' id='txt_name' type=text name='nip' value='<?php if (isset($nip)) echo $nip; ?>' />&nbsp*</td></tr>
		<tr><td>Alamat</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='alamat' value='<?php if (isset($alamat)) echo $alamat; ?>' /></td></tr>
		<tr><td>Tanggal Lahir</td><td><input class='f_txt_field' id='txt_name' type=text name='ttl' value='<?php if (isset($ttl)) echo $ttl; ?>' /><small>&nbspformat&nbsp(YYYYMMDD)</small> </td></tr>
		<tr><td>Ijazah</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='pddk' value='<?php if (isset($pddk)) echo $pddk; ?>' /></td></tr>
		<tr><td>Email</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='email' value='<?php if (isset($email)) echo $email; ?>' /></td></tr>
		<tr><td>Website</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='web' value='<?php if (isset($web)) echo $web; ?>' /></td></tr>
		<tr><td>Bidang Ilmu</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='bidilmu' value='<?php if (isset($bidilmu)) echo $bidilmu; ?>' /></td></tr>
		<tr><td>Laboratorium</td><td><input class='f_txt_field' id='txt_name' type=text name='lab' value='<?php if (isset($lab)) echo $lab; ?>' /></td></tr>
		<tr><td>Mata Kuliah</td><td><input class='f_txt_field' style='width:60%' id='txt_name' type=text name='matkul' value='<?php if (isset($matkul)) echo $matkul; ?>' /></td></tr>
		<tr><td>Nomor HP</td><td><input class='f_txt_field' id='txt_name' type=text name='hp' value='<?php if (isset($hp)) echo $hp; ?>' /></td></tr>
		<tr><td>NIDN</td><td><input class='f_txt_field' id='txt_name' type=text name='nidn' value='<?php if (isset($nidn)) echo $nidn; ?>' /></td></tr>
		<tr><td valign=top>URL Foto</td><td><input class='f_txt_field' style='width:60%'id='txt_name' type=text name='foto' value='<?php if (isset($foto)) echo $foto; ?>' /><br><small>link foto dapat diambil di daftar media</small></td></tr>
		<tr><td colspan=2><small>* wajib diisi</small></td></tr>
	</table>
	<div class='divclear'></div>
	<div class='unit'>
		<a href='<?php echo base_url('/admin/staff'); ?>' class='button_admin btn_back'>&laquo; Batal</a>
		<input class='button_admin btn_save' type='submit' value='Simpan'>
	</div>
	
	<input type='hidden' name='form_submit' value='LINK_POST_FORM' />
</form>
<?php } // end if ?>