<style>
#div_gbform {
	max-width: 500px;
	width: 100%;
}
#table_gbform {
	width: 100%;
}
#gb_name, #gb_email, #gb_website {
	width: 90%;
	max-width: 300px;
}
#gb_content {
	width: 100%;
	max-width: 450px;
	min-width: 50px;
	height: 200px;
	max-height: 300px;
	min-height: 50px;
}
.site_gb_item {
	margin: 5px;
	padding: 10px;
	background: #E8F4FF;
	border: solid 1px #C4E4FF;
}
.site_gb_hl {
	width: 45%;
	max-width: 300px;
	float: left;
	font-size: 12px;
}
.site_gb_hr {
	width: 45%;
	max-width: 320px;
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
	<div id='div_gbform'>
	<form action='<?php echo base_url('/guestbook/#guestbook'); ?>' method='POST'>
	<table id='table_gbform'>
		<tr><td><label for='gb_name'>Nama *</label></td><td><input type='text' name='f_gb_name' id='gb_name' value='<?php if (isset($f_name)) echo $f_name; ?>' maxlength="64"/></td></tr>
		<tr><td><label for='gb_email'>E-mail *</label></td><td><input type='text' name='f_gb_email' id='gb_email' value='<?php if (isset($f_email)) echo $f_email; ?>' maxlength="64"/></td></tr>
		<tr><td><label for='gb_website'>Website</label></td><td><input type='text' name='f_gb_website' id='gb_website' value='<?php if (isset($f_website)) echo $f_website; ?>' maxlength="64"/></td></tr>
		<tr><td colspan='2'><label for='gb_content'>Pesan *</label><br>
		<textarea id='gb_content' name='f_gb_content'><?php if (isset($f_content)) echo htmlentities($f_content); ?></textarea>
		<br><small>* harus diisi</small></td></tr>
		<tr><td colspan='2' style='text-align: right;'><input type='submit' value='Kirim'/></td></tr>
	</table>
	<input type='hidden' name='form_submit' value='GUESTBOOK_FORM' />
	</form>
	</div>
<?php } else { // else if
		if (empty($infos)) echo "<a href='".base_url('/guestbook/#guestbook')."'>..:: Tulis Pesan Anda sendiri ::..</a>\n";
	} // end if ?>
	<hr>
	
	<div>
	<?php
	foreach($gmessages as $_message) {
		echo "<div class='site_gb_item'>\n";
		echo "<div class='site_gb_head'>\n";
		echo "	<div class='site_gb_head_item'><div class='site_gb_hl'>{$_message->f_date}</div><div class='divclear'></div></div>\n";
		echo "	<div class='site_gb_head_item'>";
		if (!empty($_message->f_website)) {
			$_web = $_message->f_website;
			if (substr_compare($_web, 'http', 0, 4, true) != 0) $_web = 'http://'.$_web;
			echo "<a href='{$_web}'>{$_message->f_name}</a>";
		} else {
			echo "<a>{$_message->f_name}</a>\n";
		}
		echo "<span class='gbi_email'>(<a href='mailto:{$_message->f_email}'>{$_message->f_email}</a>)</span> menulis:</div>\n";
		echo "</div>\n";
		echo "<div class='site_gb_cnt'>".htmlentities($_message->f_message)."</div>\n";
		echo "</div>\n";
	}
	?>
	</div>
	<div class='site_list_nav'>
		<?php if (isset($_paging)) echo $_paging; ?>
	</div>
</div>