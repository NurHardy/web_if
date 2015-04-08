<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.cleditor.min.js'); ?>"></script>
<!-- <script type="text/javascript" src="/assets/js/jquery.cleditor.table.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.cleditor.extimage.js'); ?>"></script>
<link href="<?php echo base_url('/assets/css/jquery.cleditor.css'); ?>" rel="stylesheet" type="text/css">

<script type="text/javascript">
/*(function($) {
 
  // Define the button
  
  $.cleditor.buttons.readmore = {
    name: "readmore",
    image: "../images/cleditor/readmore.gif",
    title: "Insert Readmore area",
    command: "inserthtml",
    popupName: "readmore", //"hello",
    popupClass: null, //"cleditorPrompt",
    popupContent: null, //"Enter your name:<br><input type=text size=10><br><input type=button value=Submit>",
    buttonClick: readmoreClick
  };
 
  // Add the button to the default controls before the bold button
  $.cleditor.defaultOptions.controls = $.cleditor.defaultOptions.controls
    .replace("bold", "readmore bold");
 
  // Handle the hello button click event
	function readmoreClick(e, data) {
		var editor = data.editor;
		//
		var ret;
		if (editor.doc.getSelection) {
			var selectionRange = editor.doc.getSelection ();
			if (selectionRange.focusNode) {
				var anchorNodeProp = selectionRange.focusNode;
				//if (ie) ret = editor.doc.selection;
				ret = anchorNodeProp.tagName;
				alert(anchorNodeProp.parentNode.nodeName+" > "+anchorNodeProp.nodeName+" "+anchorNodeProp.nodeType);
			} else {
				alert("No selection focus...");
			}
		} else {
			alert("No selection...");
		}
		var html = "<div class='readmore'>" + editor.selectedHTML(editor) +"</div>";
		editor.execCommand(data.command, html, false, data.button);
		editor.focus();
	}
 
})(jQuery);*/

	function unAttachConfirm() {
		window.onbeforeunload = null;
	}
	var isSaved = true;
	var setUnsaved = function( event ) {isSaved = false;};
	var mainEditor;

	$(document).ready(function() {
		$.cleditor.buttons.image.uploadUrl = '<?php echo base_url('/admin/media/uploadonce'); ?>';
		
		mainEditor = $("#input").cleditor({
			height:		 500,
			useCSS:       true, // use CSS to style HTML when possible (not supported in ie)
			docCSSFile:   // CSS file used to style the document contained within the editor
				"<?php echo base_url('/assets/css/admin.css'); ?>",
			bodyStyle: "font-family: 'Trebuchet MS',Arial,Helvetica,sans-serif; font-size: 14px; line-height: 1.4; color:#464242;"
		})[0];
		mainEditor.change(setUnsaved);
		mainEditor.focus();
		
		$("#txt_post_title").keyup(setUnsaved);
		$("#txt_post_cat").change(setUnsaved);
	});

	<?php if (!isset($no_form)) { ?>
	window.onbeforeunload = function (e) {
		if (isSaved) return;
		var message = "Menutup jendela ini menyebabkan pekerjaan Anda hilang.",
		e = e || window.event;
		// For IE and Firefox
		if (e) {
			e.returnValue = message;
		}
		// For Safari
		return message;
	};
	
	function savedraft() {
		var _form_data = $("#form_posting").serialize();
		$.ajax({  
		  type: "POST",  
		  url: "<?php echo base_url('/admin/posts/postsavedraft'); ?>",  
		  data: _form_data,  
		  success: function(data) {
			try {
				var _result = JSON.parse(data);
				if (_result.status == 'OK') {
					$('#form_status').html("Draft saved at "+_result.datestr);
					$('#txt_draft_id').val(_result.newid);
					isSaved = true;
					$("#form_draft_stat").html(_result.datestr);
				} else {
					$('#form_status').html(_result.message);
				}
			} catch (e) {
				$('#form_status').html("Cannot parsing data! Data = "+data);
			}
			$('#form_status').hide()  
			.fadeIn(500);  
		  }  
		});
	}
	function openWindow()
	{
		$.ajax({
			type: "POST", 
			url: "<?php echo base_url('/admin/posts/preview'); ?>",
			beforeSend: function() {
				show_overlay("Memproses pratinjau...");
				$("#form_status").html("Memproses pratinjau...");
				$("#btn_preview").attr('disabled',true);
			},
			data: {
				txt_post_title:  $("#txt_post_title").val(),
				txt_post_content: $("#input").val(),
			},
			success: function(data){
				var win = window.open('','',"width=1064,height=500,scrollbars=yes,left=64,top=64");
				win.document.open();
				win.document.write(data);
				win.document.close();
				$("#form_status").html("OK");
			}
		}).always(function(){
			hide_overlay();
			$("#btn_preview").removeAttr('disabled');
		});  
		//window.open("http://localhost:8080", '');
		//window.focus();
	}
	
	function selectDocument() {
		var formTitle = "Pilih Dokumen";
		show_form_overlay("media/select","docs.select", -1, formTitle);
		return false;
	}
	
	function selectPhoto() {
		var formTitle = "Pilih Foto";
		show_form_overlay("media/select","photo.select", -1, formTitle);
		return false;
	}
	
	function insertText(text) {
		if (mainEditor) {
			var text_to_add = text;
			mainEditor.execCommand('inserthtml', text_to_add, false);
		}
	}
	
	function insertDocument(docName, docLink) {
		var icoPath = "<?php echo base_url("/assets/media/document.png"); ?>";
		insertText("<a href=\""+docLink+"\"><img src=\""+icoPath+"\" alt=\"\" style=\"vertical-align: middle;\"/> "+docName+"</a> -");
		//insertText("<a href=\""+docLink+"\"><span class=\"site_docs_item\">"+docName+"</span></a>");
	}
	<?php } // end if ?>
</script>

<div class="admin_form_wrapper">
	<h2><i class="site_icon-pencil"></i> <?php if (isset($content_title)) echo $content_title; else echo "Posting Baru"; ?></h2>
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
	<form action='<?php if (isset($form_action)) echo $form_action; else echo base_url('/admin/posts/newpost'); ?>' method='post' onsubmit="unAttachConfirm();" id='form_posting'>
		<div class='admin_form_item'>
			<div class='admin_form_label'>
				<label for='txt_post_title'>Judul</label>
			</div>
			<div class='admin_form_field'>
				<input type='text' id='txt_post_title' name='txt_post_title'
					value="<?php if (isset($f_title)) echo htmlspecialchars($f_title); ?>" style='width: 80%; min-width: 200px;'/><br>
			</div>
			<div class='divclear'></div>
		</div>
		<div class='admin_form_item'>
			<div class='admin_form_label'><label for='txt_post_cat'>Kategori</label></div>
			<div class='admin_form_field'>
				<select name='txt_post_cat' id='txt_post_cat'>
				<?php
					if (!isset($ucatprev)) $ucatprev = 0;
					if (!isset($udefcat)) $udefcat = 0;
					
					if ($udefcat == 0) echo "<option value='0'>- Pilih Kategori -</option>\n";
					$idsel_ = 0;
					if (!empty($f_cat)) $idsel_ = $f_cat;
					else $idsel_ = $udefcat;
					
					foreach($_cats as $_cat) {
						echo "<option value='".$_cat->f_id."'";
						if ($_cat->f_id == $idsel_) echo " selected";
						echo ">".$_cat->f_name."</option>\n";
					} ?>
				</select>
			</div>
			<div class='divclear'></div>
		</div>
		<div class='admin_form_item'>
			<div class='admin_form_label'>Draf tersimpan</div>
			<div class='admin_form_field'><span id='form_draft_stat'><?php
				if (isset($f_last_saved)) {
					echo date('j F Y, H:i',strtotime($f_last_saved));
					$satuan = 'menit';
					$ts1 = strtotime($f_last_saved);
					$ts2 = strtotime(date('j F Y, H:i'));
					$t_diff = floor(abs($ts2 - $ts1)/60);
					if ($t_diff >= 60) {$t_diff = floor($t_diff / 60);$satuan = 'jam';}
					if ($t_diff >= 24) {$t_diff = floor($t_diff / 24);$satuan = 'hari';}
					
					echo " ($t_diff $satuan yang lalu)";
				} else echo "Draf ini belum tersimpan." ?></span></div>
			<div class='divclear'></div>
		</div>
		<!-- Insert media -->
		<div style="margin: 20px 0 10px;">
			<a href="#" onclick="return selectDocument();" class="button_admin"><i class="site_icon-doc"></i>Sisipkan dokumen...</a>
			<a href="#" onclick="return selectPhoto();" class="button_admin"><i class="site_icon-picture"></i>Sisipkan Gambar...</a>
		</div>
		
		<!-- Main Textarea -->
		<textarea id="input" name="txt_post_content"><?php if (isset($f_content)) echo htmlspecialchars($f_content); ?></textarea>
		<!-- <input type='hidden' name='f_post_id' value='<?php if (isset($$post_id_)) echo $post_id_; ?>' /> -->
		<!-- <input type='hidden' name='form_action' value='<?php //echo $post_action; ?>' /> -->
		
		<input type='hidden' name='form_submit' value='POSTING_FORM' />
		<input type='hidden' name='txt_post_id' value='<?php if (isset($f_post_id)) echo $f_post_id; else echo "-1"; ?>' />
		<input type='hidden' name='txt_draft_id' id='txt_draft_id' value='<?php if (isset($f_draft_id)) echo $f_draft_id; else echo "-1"; ?>' />
		
		<div><small>Pastikan pop-up blocker dimatikan untuk melihat pratinjau.</small></div>
		
		<a href='<?php echo base_url('/admin/posts'); ?>' class='button_admin btn_back'>&laquo; Batal</a>
		<input type='button' value='Pratinjau' class='button_admin btn_search' onclick='openWindow()' id='btn_preview'/>
		<input type='button' value='Simpan Draf' class='button_admin btn_sdraft' onclick='savedraft();' id='btn_savedraft'/>
		<!-- <select name='form_next_act'>
			<option value='publish' selected>Publikasikan</option>
			<option value='draft'>Simpan sebagai draft</option>
		</select> -->
		<input type='submit' value='Publikasikan' class='button_admin btn_publish'/>
		<div id='form_status'></div>
	</form>
	<?php } // end if ?>
</div>