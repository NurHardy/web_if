<h2><?php if (isset($content_title)) echo $content_title; else echo "Ganti Kata Sandi"; ?></h2>
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
<?php if (!isset($no_form)) { ?>
<fieldset id='fset_auth'>
<legend>Password</legend>
<form action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/changeauth'; ?>' method='POST'>
	<b>Username</b> : <?php if (isset($target_uname)) echo $target_uname; else echo "&lt; undefined &gt;"; ?>
<?php if (isset($isself)) { 
?>	<label for='f_uopass'>Password lama:</label><input type='password' name='f_passw' id='f_uopass' placeholder='old password' class='f_txt_field'/>
<?php } // end if
?>	<label for='f_upass1'>Password baru:</label><input type='password' name='f_passw1' id='f_upass1' placeholder='new password' class='f_txt_field'/>
	<label for='f_upass2'>Tulis password baru lagi:</label><input type='password' name='f_passw2' id='f_upass2' placeholder='confirm' class='f_txt_field'/>
	<input class='button_admin' type='submit' value='Ganti'>
	<input type='hidden' name='form_submit' value='AUTH_FORM' />
</form>
</fieldset>
<?php } // end if ?>
<style>
label {display: block; cursor: pointer;}
.f_txt_field {width: 100%;}
#fset_auth {width: 400px;}
</style>