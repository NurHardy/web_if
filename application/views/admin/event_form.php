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
<?php if (!isset($no_form)) { // ================?>
<form method=POST action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/newevent'; ?>'>
	<div class='unit'><label class='lebar_unit' for='txt_name'>Nama</label><input class='f_txt_field' id='txt_name' type=text name='f_ev_name' value='<?php if (isset($f_ev_name)) echo $f_ev_name; ?>'></div>
	<div class='unit'><label class='lebar_unit' for='txt_date'>Tanggal</label><input class='f_txt_field' id='txt_date' type=text name='f_ev_date' value='<?php if (isset($f_date_str)) echo $f_date_str;?>'></div>
	<div class='unit'><label class='lebar_unit' for='txt_desc'>Deskripsi</label>
		<textarea class='deskripsi' id='txt_desc' name='f_ev_desc'><?php if (isset($f_ev_desc)) echo $f_ev_desc; ?></textarea></div>
	<div class='unit'>
	<select name='f_ev_status'>
		<option value='1' selected>Publikasikan</option>
		<option value='0'>Simpan sebagai draf</option>
	</select>
	<input class='button_admin' type='submit' value='Simpan'>
	<input class='button_admin' type=button value=batal onclick="window.location.href='/admin/events<?php if (isset($f_m)) echo '?f_month='.$f_m; ?>'">
	</div>
	<input type='hidden' name='form_submit' value='EVENT_POST_FORM' />
</form>
<?php } // ================ ?>