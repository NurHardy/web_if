<script type="text/javascript" src="/assets/js/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.cleditor.table.min.js"></script>
<link href="/assets/css/jquery.cleditor.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
(function($) {
 
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
		//var html = "<div class='readmore'>" + editor.selectedHTML(editor) +"</div>";
		//editor.execCommand(data.command, html, false, data.button);
		editor.focus();
	}
 
})(jQuery);

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
	
	function savedraft() {
		var _form_data = $("#form_posting").serialize();
		$.ajax({  
		  type: "POST",  
		  url: "/admin/postsavedraft",  
		  data: _form_data,  
		  success: function(data) {
			try {
				var _result = JSON.parse(data);
				if (_result.status == 'OK') {
					$('#form_status').html("Draft saved at "+_result.datestr);
					$('#txt_draft_id').val(_result.newid);
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
	<?php } // end if ?>
</script>

<h2><?php if (isset($content_title)) echo $content_title; else echo "Posting Baru"; ?></h2>
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
<form action='<?php if (isset($form_action)) echo $form_action; else echo '/admin/newpost'; ?>' method='post' onsubmit="unAttachConfirm();" id='form_posting'>
	<label for='txt_post_title'>Judul</label><input type='text' id='txt_post_title' name='txt_post_title' value='<?php if (isset($f_title)) echo $f_title; ?>' style='width: 75%; min-width: 200px;'/><br>
	<label for='txt_post_cat'>Kategori</label>
	<select name='txt_post_cat' id='txt_post_cat'>
		<option value='0'>- Pilih Kategori -</option>
		<?php foreach($_cats as $_cat) { ?>
			<option <?php
				echo "value='".$_cat->f_id."'";
				if (isset($f_cat))
					if ($_cat->f_id == $f_cat) echo " selected"; ?>><?php echo $_cat->f_name; ?></option>
		<?php } ?>
	</select>
	<br>
	<textarea id="input" name="txt_post_content"><?php if (isset($f_content)) echo htmlentities($f_content); ?></textarea>
	<!-- <input type='hidden' name='f_post_id' value='<?php if (isset($$post_id_)) echo $post_id_; ?>' /> -->
	<!-- <input type='hidden' name='form_action' value='<?php //echo $post_action; ?>' /> -->
	<input type='hidden' name='form_submit' value='POSTING_FORM' />
	<input type='hidden' name='txt_post_id' value='<?php if (isset($f_post_id)) echo $f_post_id; else echo "-1"; ?>' />
	<input type='hidden' name='txt_draft_id' id='txt_draft_id' value='<?php if (isset($f_draft_id)) echo $f_draft_id; else echo "-1"; ?>' />
	<input type='button' value='Simpan Draf' class='button_admin' onclick='savedraft();'/>
	<!-- <select name='form_next_act'>
		<option value='publish' selected>Publikasikan</option>
		<option value='draft'>Simpan sebagai draft</option>
	</select> -->
	<input type='submit' value='Publikasikan' class='button_admin'/>
	<div id='form_status'></div>
</form>
<?php } // end if ?>