<style>
.site_gb_item {
	margin: 5px;
	padding: 10px;
	background: #E8F4FF;
	border: solid 1px #C4E4FF;
}
.site_gb_hl {
	width: 100px;
	float: left
}
.site_gb_hr {
	width: 520px;
	float: right;
}
.site_gb_cnt {
	background: #F7FBFF;
	padding: 5px;
}

</style>
<div id='site_content_article'>
	<h2 id='guestbook'><?php if (isset($content_title)) echo $content_title; else echo "Buku Tamu"; ?></h2>
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

if (!isset($no_form)) { ?>
	<form action='/guestbook/#guestbook' method='POST'>
	<label for='gb_name'>Nama</label><input type='text' name='f_gb_name' id='gb_name' value='<?php if (isset($f_name)) echo $f_name; ?>'/><br>
	<label for='gb_email'>E-mail</label><input type='text' name='f_gb_email' id='gb_email' value='<?php if (isset($f_email)) echo $f_email; ?>'/><br>
	<label for='gb_website'>Website</label><input type='text' name='f_gb_website' id='gb_website' value='<?php if (isset($f_website)) echo $f_website; ?>'/><br>
	<label for='gb_content'>Pesan</label><br>
	<textarea id='gb_content' name='f_gb_content'><?php if (isset($f_content)) echo htmlentities($f_content); ?></textarea>
	<input type='submit' value='Kirim'/>
	<input type='hidden' name='form_submit' value='GUESTBOOK_FORM' />
	</form>
<?php } // end if ?>
	<hr>
	
	<div>
	<?php
	foreach($gmessages as $_message) {
		echo "<div class='site_gb_item'>\n";
		echo "<div class='site_gb_head'>\n";
		echo "	<div class='site_gb_head_item'><div class='site_gb_hl'>Nama</div><div class='site_gb_hr'>{$_message->f_name}</div><div class='divclear'></div></div>\n";
		echo "	<div class='site_gb_head_item'><div class='site_gb_hl'>E-mail</div><div class='site_gb_hr'>{$_message->f_message}</div><div class='divclear'></div></div>\n";
		echo "	<div class='site_gb_head_item'><div class='site_gb_hl'>Website</div><div class='site_gb_hr'>{$_message->f_website}</div><div class='divclear'></div></div>\n";
		echo "</div>\n";
		echo "<div class='site_gb_cnt'>{$_message->f_message}</div>\n";
		echo "</div>\n";
	}
	?>
	</div>
	<div class='site_list_nav'>
		<?php if (isset($_paging)) echo $_paging; ?>
	</div>
</div>