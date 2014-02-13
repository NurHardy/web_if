<style>
label {margin-left: 5px; cursor: pointer;}
.unit {display:block; margin: 5px;}
#f_uname_info {padding: 5px;}
.info_error_mark {background: #FFB2B2;}
.info_fine_mark {background: #D6FFBC;}
.f_txt_field {width:100%; display:block;}
.lebar_unit {display:block;}
#fset_basic {width: 300px; float: left;}
#fset_previleges {width: 300px; float: left;}
#fset_categories {width: 250px; overflow: hidden;}
#fset_categories_div {display:none;}
.unit_cat {display: block; padding: 5px;}
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
			url: "/admin/users/checkusername",
			data: {uname: _uname},
			success: function(data) {
				$("#f_uname_info").html(data);
			},
			error: function() {
				$("#f_uname_info").html("<span class='info_error_mark'>Terjadi kesalahan. Silakan coba lagi</span>");
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
<form method='POST' action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/users/newuser'; ?>'>
	<fieldset id='fset_basic'>
		<legend>Informasi User</legend>
		<div class='unit'><label class='lebar_unit' for='f_fullname'>Nama Lengkap User</label><input class='f_txt_field' id='f_fullname' type=text name='f_fullname' value='<?php if (isset($f_fullname)) echo $f_fullname; ?>'></div>
		<div class='unit'><label class='lebar_unit' for='f_username'>Nama User</label>
		<input class='f_txt_field' id='f_username' type=text name='f_username' value='<?php if (isset($f_username)) echo $f_username; ?>' onchange='cek_username();'>
		<small id='f_uname_info'>Informasi di sini</small></div>
		<div class='unit'><label class='lebar_unit' for='f_email'>Email</label><input class='f_txt_field' id='f_email' type=text name='f_email' value='<?php if (isset($f_email)) echo $f_email; ?>'></div>
		<div class='unit'><label class='lebar_unit' for='f_passw1'>Password</label><input class='f_txt_field' id='f_passw1' type=password name='f_passw1' value='' placeholder='password' onchange='cek_password();'>
		<small id='f_pass_info'>-</small></div>
		<div class='unit'><label class='lebar_unit' for='f_passw2'>Confirm</label><input class='f_txt_field' id='f_passw2' type=password name='f_passw2' value='' placeholder='confirm' onchange='cek_konfirmasi();'>
		<small id='f_conf_info'>-</small></div>
	</fieldset>
	<fieldset id='fset_previleges'>
		<legend>User Previleges</legend>
		<div class='unit'><input type='checkbox' id='f_prev_admin' name='f_prev_admin'/><label for='f_prev_admin' title='User dapat membuat, mengedit dan menghapus user bukan admin.'>Admin</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_posts' name='f_prev_posts' onchange='toggle_cat_panel(this);'/><label for='f_prev_posts' title='User dapat membuat, mengedit dan menghapus posting.'>Manage Posts</label>
		<div id='fset_categories_div'>
		<fieldset id='fset_categories'>
			<legend>Allowed Categories</legend>
<?php foreach($_cats as $_cat) {
	$_idcat = $_cat->f_id; ?>
	<div class='unit_cat'><input type='checkbox' name='f_prev_cat[]' value='<?php echo $_idcat; ?>' id='f_prev_cat_<?php echo $_idcat; ?>'/>
	<label for='f_prev_cat_<?php echo $_idcat; ?>'><?php echo $_cat->f_name; ?></label>&nbsp;&nbsp;<input type='radio' name='f_def_cat' id='f_def_cat_<?php echo $_idcat; ?>' />
	<label for='f_def_cat_<?php echo $_idcat; ?>'>default</label></div>
<?php } ?>
			</fieldset>
			<div class='divclear'></div>
			</div>
		</div>
		<div class='unit'><input type='checkbox' id='f_prev_pages' name='f_prev_pages'/><label for='f_prev_pages' title='User dapat membuat, mengedit dan menghapus halaman.'>Manage Pages</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_events' name='f_prev_events'/><label for='f_prev_events' title='User dapat membuat, mengedit dan menghapus agenda.'>Manage Events</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_links' name='f_prev_links'/><label for='f_prev_links'>Manage Links</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_medias' name='f_prev_medias'/><label for='f_prev_medias'>Manage Medias</label></div>
		<div class='unit'><input type='checkbox' id='f_prev_menu' name='f_prev_menu'/><label for='f_prev_menu'>Manage Menu</label></div>
	</fieldset>
	<div class='divclear'></div>
	<div class='unit'><input class='button_admin' type='submit' value='Simpan'> </div>
	<input type='hidden' name='form_submit' value='USER_POST_FORM' />
</form>
<?php } // end if ?>