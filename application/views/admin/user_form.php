<style>
label {margin-left: 5px; cursor: pointer;}
.unit {display:block; margin: 5px;}
#f_uname_info {padding: 5px;}
.f_txt_field {width:100%; display:block;}
.lebar_unit {display:block;}
#fset_basic {width: 300px; float: left;}
#fset_previleges {width: 300px; float: left;}
#fset_categories {width: 250px; overflow: hidden;}
#fset_categories_div {display:none;}
.unit_cat {display: block; padding: 5px;}
.unit_cat:hover {background-color: #EDF6FF;}
.unit_cat_l {float: left; width: 100px;}
.unit_cat_r {float: right; width: 100px;}
</style>
<script>
	function cek_password() {
		var _pass = $('#f_passw1').val();
		if (_pass == "") {
			$("#f_pass_info").html("<span class='info_error_mark'>Isikan kata kunci.</span>");
		} else if (_pass.length < 5) {
			$("#f_pass_info").html("<span class='info_error_mark'>Kata kunci minimal 5 karakter.</span>");
		} else {
			$("#f_pass_info").html("<span class='info_fine_mark'>OK</span>");
			cek_konfirmasi();
		}
	}
	function cek_konfirmasi() {
		var _pass1 = $('#f_passw1').val();
		var _pass2 = $('#f_passw2').val();
		if (_pass2 == "") {
			$("#f_conf_info").html("<span class='info_error_mark'>Ketik ulang password</span>");
		} else if (_pass1 != _pass2) {
			$("#f_conf_info").html("<span class='info_error_mark'>Tidak sama</span>");
		} else {
			$("#f_conf_info").html("<span class='info_fine_mark'>Sama</span>");
		}
	}
	function cek_username() {
		var _uname = $('#f_username').val();
		if (_uname != "") $("#f_uname_info").html('Mengecek...');
		else {$("#f_uname_info").html('<span class="info_error_mark">Username harus diisi</span>'); return;}
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('/admin/users/checkusername'); ?>",
			data: {uname: _uname},
			success: function(data) {
				$("#f_uname_info").html(data);
			},
			error: function() {
				$("#f_uname_info").html("<span class='info_error_mark'>Terjadi kesalahan. <a href='javascript:cek_username()'>Coba lagi</a></span>");
			}
		});  
	}
	function toggle_cat_panel(cb) {
		if (cb.checked) {
			$("#fset_categories_div").slideDown('fast');
		} else {
			$("#fset_categories_div").slideUp('fast');
		}
	}
	function cat_check(_id) {
		$("#f_def_cat_"+_id).removeAttr('disabled');
		$("#f_def_cat_r"+_id).show();
	}
	function cat_uncheck(_id) {
		$("#f_def_cat_"+_id).attr('disabled',true);
		$("#f_def_cat_r"+_id).hide();
		if ($("#f_def_cat_"+_id).is(':checked')) {
			$("#f_def_cat_"+_id).removeAttr('checked');
			$("#f_def_cat_0").attr('checked',true);
		}
	}
	function cat_check_all(c) {
		$("#fset_categories").find(":checkbox").each(function() {
			var _id; _id=$(this).val();
			if (c) {
				$(this).attr('checked',true);
				cat_check(_id);
			} else {
				cat_uncheck(_id);
				$(this).removeAttr('checked');
			}
		});
		check_selcat();
	}
	function catcheck(cb,_id) {
		if (cb.checked) {
			cat_check(_id);
		} else {
			cat_uncheck(_id);
		}
		check_selcat();
	}
	function check_selcat() {
		if ($('#fset_categories input:checkbox:checked').length > 0) $("#no_sel_warn").hide();
		else $("#no_sel_warn").show();
	}
	function toggle_nonadmin(cb) {
		if (cb.checked) {
			$("#f_prev_nonadmin").slideUp('fast');
		} else {
			$("#f_prev_nonadmin").slideDown('fast');
		}
	}
</script>
<h2><?php if (isset($content_title)) echo $content_title; else echo "User Baru"; ?></h2>
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
<form method='POST' action='<?php if (isset($form_action)) echo $form_action; else echo base_url('/admin/users/newuser'); ?>' id='userform'>
	<fieldset id='fset_basic'>
		<legend>Informasi User</legend>
		<div class='unit'>
	<?php if (!isset($_is_editing)) { // if not editing ===========?>
		<label class='lebar_unit' for='f_username' title='Username ini digunakan untuk login.'>Nama User</label>
		<input class='f_txt_field' id='f_username' type='text' name='f_username' value='<?php if (isset($f_username)) echo $f_username; ?>' onchange='cek_username();'>
		<small id='f_uname_info'>Informasi di sini</small>
	<?php } else { // else ================= ?>
		<span class='lebar_unit' title='Nama User'>Nama User</span>
		<b><?php if (isset($f_username)) echo $f_username; ?></b>
		<input type='hidden' name='f_username' value='<?php if (isset($f_username)) echo $f_username; ?>'/>
	<?php } // end if ================= ?>
	</div>
		<div class='unit'><label class='lebar_unit' for='f_fullname'>Nama Lengkap User</label><input class='f_txt_field' id='f_fullname' type=text name='f_fullname' value='<?php if (isset($f_fullname)) echo $f_fullname; ?>'></div>
		<div class='unit'><label class='lebar_unit' for='f_email'>Email</label><input class='f_txt_field' id='f_email' type=text name='f_email' value='<?php if (isset($f_email)) echo $f_email; ?>'></div>
	<?php if (!isset($_is_editing)) { // if not editing ===========?>
		<div class='unit'><label class='lebar_unit' for='f_passw1'>Password</label><input class='f_txt_field' id='f_passw1' type=password name='f_passw1' value='' placeholder='password' onchange='cek_password();'>
		<small id='f_pass_info'>-</small></div>
		<div class='unit'><label class='lebar_unit' for='f_passw2'>Confirm</label><input class='f_txt_field' id='f_passw2' type=password name='f_passw2' value='' placeholder='confirm' onchange='cek_konfirmasi();'>
		<small id='f_conf_info'>-</small></div>
	<?php } // end if ================= ?>
	</fieldset>
	<fieldset id='fset_previleges'>
		<legend>User Previleges</legend>
		<div class='unit'><input type='checkbox' id='f_prev_admin' name='f_prev_[0]' value='1' <?php if (isset($f_userprev[0])) echo "checked='checked'"; ?> onchange='toggle_nonadmin(this);'/><label for='f_prev_admin' title='User merupakan administrator yang dapat mengatur SEMUA fitur website termasuk manajemen akun.'>Admin</label></div>
		<hr>
	<!-- non-admin -->
	<div id='f_prev_nonadmin' <?php if (isset($f_userprev[0])) echo "style='display:none;'"; ?> >
		<div class='unit'><input type='checkbox' id='f_prev_posts' name='f_prev_[1]' value='1' <?php if (isset($f_userprev[1])) echo "checked='checked'"; ?> onchange='toggle_cat_panel(this);'/><label for='f_prev_posts' title='User dapat membuat, mengedit dan menghapus posting.'>Manage Posts</label>
		<div id='fset_categories_div' <?php if (isset($f_userprev[1])) echo "style='display: block'"; ?>>
		<fieldset id='fset_categories'>
			<legend>Allowed Categories</legend>
	<div class='unit_cat'>
		<input type='button' onclick='cat_check_all(true);' value='Check All' class='button_admin'/>
		<input type='button' onclick='cat_check_all(false);' value='Uncheck All' class='button_admin'/>
	</div>
	<div class='unit_cat'>
		<div class='unit_cat_r'><input type='radio' name='f_def_cat' id='f_def_cat_0' value='0' <?php if ($f_defcat==0) echo "checked='checked'"; ?> />
			<label for='f_def_cat_0'>No default</label></div>
		<div class='divclear'></div>
	</div>
<?php
	$is_active = false;
	foreach($_cats as $_cat) {
		$_idcat = $_cat->f_id;
		$is_active = $f_catflag & (1 << ($_idcat-1));
	?>
	<!-- UNDER CONSTRUCTION...! -->
	<div class='unit_cat'>
		<div class='unit_cat_l'>
			<?php echo "<input type='checkbox' name='f_prev_cat[]' value='{$_idcat}' id='f_prev_cat_{$_idcat}' onchange='catcheck(this,{$_idcat});' ";
			if ($is_active) echo "checked='checked'";
			echo "/>\n"; ?>
			<label for='f_prev_cat_<?php echo $_idcat; ?>'><?php echo $_cat->f_name; ?></label></div>
		<div class='unit_cat_r'>
			<input type='radio' name='f_def_cat' id='f_def_cat_<?php echo $_idcat; ?>' value='<?php echo $_idcat; ?>' <?php if ($f_defcat==$_idcat) echo "checked='checked' "; if (!$is_active) echo "disabled='disabled'"; ?> />
			<label for='f_def_cat_<?php echo $_idcat; ?>' id='f_def_cat_r<?php echo $_idcat; ?>' <?php if (!$is_active) echo "style='display:none;'"; ?>>default</label></div>
		<div class='divclear'></div>
	</div>
<?php } ?>
			<span class='info_error_mark' id='no_sel_warn' style='display:none;'>Tidak ada kategori yang dipilih!</span>
			</fieldset>
			<div class='divclear'></div>
			</div>
		</div>
		<div class='unit'><input type='checkbox' id='f_prev_pages' name='f_prev_[2]' value='1' <?php if (isset($f_userprev[2])) echo "checked='checked'"; ?> /><label for='f_prev_pages' title='User dapat membuat, mengedit dan menghapus halaman.'>Manage Pages</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_events' name='f_prev_[3]' value='1' <?php if (isset($f_userprev[3])) echo "checked='checked'"; ?> /><label for='f_prev_events' title='User dapat membuat, mengedit dan menghapus agenda.'>Manage Events</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_links' name='f_prev_[4]' value='1' <?php if (isset($f_userprev[4])) echo "checked='checked'"; ?> /><label for='f_prev_links'>Manage Links</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_medias' name='f_prev_[5]' value='1' <?php if (isset($f_userprev[5])) echo "checked='checked'"; ?> /><label for='f_prev_medias'>Manage Medias</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_slider' name='f_prev_[6]' value='1' <?php if (isset($f_userprev[6])) echo "checked='checked'"; ?> /><label for='f_prev_slider'>Manage home slider</label></div>
	</div>
	</fieldset>
	<div class='divclear'></div>
	<div class='unit'>
	<a href='<?php echo base_url('/admin/users'); ?>' class='button_admin btn_back'>&laquo; Batal</a>
	<input class='button_admin btn_save' type='submit' value='Simpan' />
	</div>
	<input type='hidden' name='form_submit' value='USER_POST_FORM' />
</form>
<?php } // end if ?>