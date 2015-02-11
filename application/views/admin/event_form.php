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
<h2><?php if (isset($content_title)) echo $content_title; else echo "Agenda Baru"; ?></h2>
<?php if (!isset($no_form)) { // ================?>
<form method=POST action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/events/newevent'; ?>'>
	<table>
		<tr><td width='170px'><label class='lable_text' for='txt_name'>Nama</label></td><td ><input class='f_txt_field' id='txt_name' type=text name='f_ev_name' value='<?php if (isset($f_ev_name)) echo $f_ev_name; ?>'></td></tr>
		<tr><td><label class='lable_text' for='txt_date'>Tanggal</label></td><td><input class='f_txt_field' id='txt_date' type=text name='f_ev_date' value='<?php if (isset($f_date_str)) echo $f_date_str;?>'></td></tr>
		<tr><td><label class='lable_text' for='txt_desc'>Deskripsi</label></td>
			<td><textarea class='deskripsi' id='txt_desc' name='f_ev_desc'><?php if (isset($f_ev_desc)) echo $f_ev_desc; ?></textarea></td></tr>
		
		<tr><td>
			<!--<select name='f_ev_status'>
			<option value='1' selected>Publikasikan</option>
			<option value='0'>Simpan sebagai draf</option>
		</select>-->
		<td><input class='button_admin' type=button value=Batal onclick="window.location.href='<?php echo base_url("/admin/events"); if (isset($f_m)) echo '?f_month='.$f_m; ?>'"><input class='button_admin' type='submit' value='Simpan'></td>
		</td></tr>
		<input type='hidden' name='form_submit' value='EVENT_POST_FORM' />
		
	</table>
</form>
<?php } // ================ ?>