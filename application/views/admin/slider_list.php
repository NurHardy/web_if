<link href="<?php echo base_url('/assets/css/diapo.css'); ?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.form.min.js'); ?>"></script>
<script>
var is_processing = false;
var processed_slideid = 0;
var _ov_msg;
var _refresh = false;
var __need_refresh = false;

	// thanks to: css-tricks.com
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	// thanks to: phpjs.org
	function nl2br (str, is_xhtml) {   
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
	}
	function slider_editlabel(_id) {
		var elem_ = $("#frm_slide_"+_id);
		var captext = elem_.find('.caption_text').html();
		elem_.find('.caption_textbox').html(captext).show();
		elem_.find('.frm_editcap_commands').show();
		elem_.find('.caption_text, .frm_slideactions').hide();
	}
	function slider_canceledit(_id) {
		var elem_ = $("#frm_slide_"+_id);
		elem_.find('.caption_textbox').empty().hide();
		elem_.find('.frm_editcap_commands').hide();
		elem_.find('.caption_text, .frm_slideactions').show();
	}
	function _slider_applycap(_id) {
		var elem_ = $("#frm_slide_"+_id);
		var newcap_ = nl2br(htmlEntities(elem_.find('.caption_textbox').val()), false)
		elem_.find('.caption_text').html(newcap_);
		elem_.find('.caption_textbox').empty().hide();
		elem_.find('.frm_editcap_commands').hide();
		elem_.find('.caption_text, .frm_slideactions').show();
	}
	function _slider_send(_postdata, _finishcallback, _msg, _needrefresh) {
		_ov_msg = _msg || 'Menyimpan...';
		__need_refresh = _needrefresh || false;
		_refresh = false;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url('/admin/slider/setprop'); ?>",
			data: _postdata,
			beforeSend: function( xhr ) {
				is_processing = true;
				show_overlay(_ov_msg);
			},
			success: function(response){
				var result = $.trim(response);
				if(result === "OK") {
					if (__need_refresh) {
						_refresh = __need_refresh;
						ov_change_msg("Me-<i>reload</i> halaman...");
					}
					_finishcallback();
				} else {
					alert('Operasi gagal: '+result);
				}
			},
			error: function(xhr){
				alert("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
			}
		}).always(function() {
			is_processing = false;
			if (!_refresh) hide_overlay();
		});
	}
	function slider_savelabel(_id) {
		if (is_processing) return;
		processed_slideid = _id;
		var elem_ = $("#frm_slide_"+_id);
		var newcap = elem_.find('.caption_textbox').val();
		
		_slider_send({
			prop: 'caption',
			id: _id,
			newcaption: newcap
		}, function() {
			_slider_applycap(processed_slideid);
		});
	}
	function slider_delete(_id) {
		if (is_processing) return;
		var _conf = confirm("Hapus slide yang Anda pilih?");
		if (_conf == false) return;
		processed_slideid = _id;
		
		_slider_send({
			prop: 'delete',
			id: _id
		}, function() {
			location.reload(true);
		}, 'Memproses...', true);
	}
	function slider_togglehide(_id) {
		if (is_processing) return;
		processed_slideid = _id;
		if ($("#frm_slide_"+_id).hasClass('slide_hidden')) {
			_slider_send({
				prop: 'published',
				id: _id,
				status: 1
			}, function() {
				$("#frm_slide_"+processed_slideid).removeClass('slide_hidden');
				$("#frm_slide_"+processed_slideid).find('.frm_tog_btn').html("Sembunyikan");
			});
		} else {
			_slider_send({
				prop: 'published',
				id: _id,
				status: 0
			}, function() {
				$("#frm_slide_"+processed_slideid).addClass('slide_hidden');
				$("#frm_slide_"+processed_slideid).find('.frm_tog_btn').html("Tampilkan");
			});
		}
	}
	
	function slider_setorder(_id) {
		if (is_processing) return;
		processed_slideid = _id;
		var newpos = $('#frm_slideorder_'+_id).val();
		
		_slider_send({
			prop: 'order',
			id: _id,
			order: newpos
		}, function() {
			location.reload(true);
		}, 'Memproses...', true);
	}
	
$(document).ready(function() {
	var options = { 
		beforeSend: function() 
		{
			is_processing = true;
			show_overlay("<div id='media_uploadprogress'>\n"+
						"<div id='media_progresstxt'>Terunggah <span id='media_progressnumb'>0%</span>. Silakan tunggu...</div>\n" +
						"<div id='media_progressbox'><div id='media_progressbar'></div></div></div>");
			$("#media_form").hide();
			$("#media_uploadprogress").show();
			//clear everything
			$("#media_progressbar").width('0%');
			$("#media_progressnumb").html("0%");
		},
		uploadProgress: function(event, position, total, percentComplete) 
		{
			$("#media_progressbar").width(percentComplete+'%');
			$("#media_progressnumb").html(percentComplete+'%');
		},
		success: function() 
		{
			$("#media_progressbar").width('100%');
			$("#media_progressnumb").html('100%');
		},
		complete: function(response) 
		{
			var resp_txt = response.responseText;
			if (resp_txt === 'OK') {
				ov_change_msg("Me-<i>reload</i> halaman...");
				location.reload(true);
			} else {
				alert(resp_txt);
				hide_overlay();
				$("#media_form").show();
			}
		},
		error: function()
		{
			is_processing = false;
			hide_overlay();
		}
	}; 

     $("#media_form").ajaxForm(options);
});

</script>

	<h2><?php echo $page_title ?></h2>
	Upload slide baru:
	<form method='POST' action='<?php echo base_url('/admin/slider/upload'); ?>' id='media_form' enctype="multipart/form-data">
		<div class='unit'><label class='lebar_unit' for='f_file'>File</label><input type="file" id='f_file' name="f_file_" />
		<input class='button_admin btn_upload' type='submit' id='btn_media_submit' value='Unggah'></div>
		<input type='hidden' name='form_submit' value='MEDIA_POST_FORM' />
	</form>
	<table cellpadding="5px" >
		<tr bgcolor="#004A87" style="color:#fff; text-align:center">
			<td>No.</td><td>Slider</td>
		</tr>
	<?php 
		$bg='#ADD7F7';$bg1='#F1F6FA';$i=1;
		foreach($_sliders as $_slider) {
		$_sid = $_slider->f_id;
		echo"<tr valign='top' bgcolor=' ".$bg1."'>";?>
			<td height="100px" width="30px">
				<?php echo $i; ?>
			</td>
			<td height="100px" width="700px">
			<div id='frm_slide_<?php echo $_sid; ?>' <?php if ($_slider->f_status==0) echo 'class="slide_hidden"'; ?>>
				<div class='priview_slider' style="background-image: url('<?php echo base_url($_slider->f_url); ?>');" alt='Slider <?php echo $i; ?>' title='<?php echo $_slider->f_url; ?>'>
					<div class='caption elemHover'>
						<span class='caption_text'><?php echo htmlentities($_slider->f_desc); ?></span>
						<textarea class='caption_textbox'></textarea>
					</div>
				</div>
				<div class='priview_actionbar'>
					<div class='frm_slideactions'>
						<button onclick="slider_editlabel(<?php echo $_sid; ?>);" class='button_admin btn_sdraft'>Edit Label</button>
						<label for='frm_slideorder_<?php echo $_sid; ?>'>Prioritas:</label><input type='text' id='frm_slideorder_<?php echo $_sid; ?>' value='<?php echo $_slider->f_order; ?>' size='4'/>
						<button onclick="slider_setorder(<?php echo $_sid; ?>);" class='button_admin'>Set Prioritas</button>
						<button onclick="slider_togglehide(<?php echo $_sid; ?>);" class='frm_tog_btn button_admin btn_publish'><?php if ($_slider->f_status==1) echo "Sembunyikan"; else echo "Tampilkan"; ?></button>
						<button onclick="slider_delete(<?php echo $_sid; ?>);" class='button_admin_red btn_delete'>Hapus</button>
					</div>
					<div class='frm_editcap_commands'>
						<button onclick="slider_canceledit(<?php echo $_sid; ?>);" class='button_admin btn_back'>Batal</button>
						<button onclick="slider_savelabel(<?php echo $_sid; ?>);"  class='button_admin btn_save'>Simpan</button>
					</div>
				</div>
			</div>
			</td>
		</tr><?php $i++; } // end foreach ?>
	</table>
