<script type="text/javascript" src="/assets/js/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cleditor.table.min.js"></script>
<link href="/assets/css/jquery.cleditor.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

function unAttachConfirm() {
	window.onbeforeunload = null;
}

	$(document).ready(function() {
		$("#input").cleditor({
			height:		 500,
			useCSS:       true, // use CSS to style HTML when possible (not supported in ie)
			docCSSFile:   // CSS file used to style the document contained within the editor
				"/assets/css/admin.css"
		})[0].focus();
	});

	
	<?php if (!isset($no_form)) { ?>
	function unAttachConfirm() {
		window.onbeforeunload = null;
	}
	window.onbeforeunload = function (e) {
		var message = "Menutup jendela ini menyebabkan pekerjaan Anda hilang. Lanjut?",
		e = e || window.event;
		// For IE and Firefox
		if (e) {
			e.returnValue = message;
		}
		// For Safari
		return message;
	};
	<?php } // end if ?>
</script>

<h2><?php if (isset($content_title)) echo $content_title; else echo "Halaman Baru"; ?></h2>
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
<form action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/newpage'; ?>' method='post' onsubmit="unAttachConfirm();">
	<label for='txt_post_title'>Judul</label><input type='text' id='txt_post_title' name='f_title' value='<?php if (isset($f_title)) echo $f_title; ?>' style='width: 75%; min-width: 200px;'/><br>
	<label for='txt_post_permalink'>Permalink</label><input type='text' id='txt_post_permalink' name='f_permalink' value='<?php if (isset($f_permalink)) echo $f_permalink; ?>' style='width: 75%; min-width: 200px;'/><br>
	<textarea id="input" name="f_content"><?php if (isset($f_content)) echo $f_content; ?></textarea>
	<input type='hidden' name='form_submit' value='PAGE_POST_FORM' ?>
	<input type='submit' value='Publikasikan' class='button_admin'/>
</form>
<?php } // end if ?>