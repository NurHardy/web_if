<script type="text/javascript" src="/assets/js/jquery.cleditor.min.js"></script>
<!-- <script type="text/javascript" src="/assets/js/jquery.cleditor.table.min.js"></script> -->
<script type="text/javascript" src="/assets/js/jquery.cleditor.extimage.js"></script>
<link href="/assets/css/jquery.cleditor.css" rel="stylesheet" type="text/css">

<script type="text/javascript">

function unAttachConfirm() {
	window.onbeforeunload = null;
}

var old_plink = "<?php if (isset($f_permalink)) echo $f_permalink; ?>";
var isSaved = true;
var setUnsaved = function( event ) {isSaved = false;};

	$(document).ready(function() {
		$("#input").cleditor({
			height:		 500,
			useCSS:       true, // use CSS to style HTML when possible (not supported in ie)
			docCSSFile:   // CSS file used to style the document contained within the editor
				"/assets/css/admin.css",
			bodyStyle: "font-family: 'Trebuchet MS',Arial,Helvetica,sans-serif;font-size: 14px;line-height: 1.4;color:#464242;"
		})[0].change(setUnsaved).focus();
		$.cleditor.buttons.image.uploadUrl = '/admin/media/uploadonce';
		$("#txt_post_title").keyup(setUnsaved);
		$("#txt_post_cat").change(setUnsaved);
	});

	<?php if (!isset($no_form)) { ?>
	function cek_permalink() {
		var _plink = $('#txt_post_permalink').val();
		if (old_plink != "")
			if (_plink.toLowerCase() === old_plink) {$("#txt_info_permalink").html('Tidak berubah...');return;}
		if (_plink != "") $("#txt_info_permalink").html('Mengecek...');
		else {$("#txt_info_permalink").html('<span class="info_error_mark">Permalink harus diisi</span>'); return;}
		$.ajax({
			type: "POST",
			url: "/admin/pages/checkpermalink",
			data: {plink: _plink},
			success: function(data) {
				$("#txt_info_permalink").html(data);
			},
			error: function() {
				$("#txt_info_permalink").html("<span class='info_error_mark'>Terjadi kesalahan. <a href='javascript:cek_permalink()'>Coba lagi</a></span>");
			}
		});  
	}
	
	function unAttachConfirm() {
		window.onbeforeunload = null;
	}
	window.onbeforeunload = function (e) {
		if (isSaved) return;
		var message = "Menutup jendela ini menyebabkan pekerjaan Anda hilang. Lanjut?",
		e = e || window.event;
		// For IE and Firefox
		if (e) {
			e.returnValue = message;
		}
		// For Safari
		return message;
	};
	function openPreview()
	{
		$.ajax({
			type: "POST", 
			url: "/admin/pages/preview",
			beforeSend: function() {
				$("#form_status").html("Memproses pratinjau...");
			},
			data: {
				f_title:  $("#txt_post_title").val(),
				f_content: $("#input").val(),
			},
			success: function(data){
				var win = window.open('','',"width=1064,height=500,scrollbars=yes,left=64,top=64");
				win.document.open();
				win.document.write(data);
				win.document.close();
				$("#form_status").html("OK");
			}
		});  
		//window.open("http://localhost:8080", '');
		//window.focus();
	}
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
<form action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/pages/newpage'; ?>' method='post' onsubmit="unAttachConfirm();">
	<div class='admin_form_item'>
		<div class='admin_form_label'><label for='txt_post_title'>Judul</label></div>
		<div class='admin_form_field'><input type='text' id='txt_post_title' name='f_title' value='<?php if (isset($f_title)) echo $f_title; ?>' style='width: 75%; min-width: 200px;'/></div>
		<div class='divclear'></div>
	</div>
	<div class='admin_form_item'>
		<div class='admin_form_label'><label for='txt_post_permalink'>Permalink</label></div>
		<div class='admin_form_field'><input type='text' id='txt_post_permalink' name='f_permalink' value='<?php if (isset($f_permalink)) echo $f_permalink; ?>' style='width: 200px; min-width: 200px;' onchange='cek_permalink();'/><br>
		<small id='txt_info_permalink'>-</small></div>
		<div class='divclear'></div>
	</div>
	<textarea id="input" name="f_content"><?php if (isset($f_content)) echo $f_content; ?></textarea>
	<div class='admin_form_item'>
		<a href='/admin/pages' class='button_admin btn_back'>&laquo; Batal</a>
		<input type='button' value='Pratinjau' class='button_admin btn_search' onclick='openPreview()' />
		<input type='submit' value='Publikasikan' class='button_admin btn_publish'/>
	</div>
	<div id='form_status'></div>
	<input type='hidden' name='form_submit' value='PAGE_POST_FORM' ?>
</form>
<?php } // end if ?>