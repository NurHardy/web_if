<h2><?php if (isset($content_title)) echo $content_title; else echo "Ganti Kata Sandi"; ?></h2>
<div class='divclear'></div>
<fieldset id='fset_auth'>
<legend>Password</legend>
<form action='/admin/userpass' method='POST'>
	<label for='f_uopass'>Password lama:</label><input type='password' name='f_uopass' id='f_uopass' placeholder='old password' class='f_txt_field'/>
	<label for='f_upass1'>Password baru:</label><input type='password' name='f_upass1' id='f_upass1' placeholder='new password' class='f_txt_field'/>
	<label for='f_upass2'>Tulis password baru lagi:</label><input type='password' name='f_upass2' id='f_upass2' placeholder='confirm' class='f_txt_field'/>
	<input class='button_admin' type='submit' value='Ganti'>
	<input type='hidden' name='form_submit' value='AUTH_FORM' />
</form>
</fieldset>
<style>
label {display: block; cursor: pointer;}
.f_txt_field {width: 100%;}
#fset_auth {width: 400px;}
</style>