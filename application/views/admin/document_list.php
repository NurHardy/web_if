<h2><?php if (isset($content_title)) echo $content_title; else echo "Daftar Dokumen"; ?></h2>
<!-- <label for='filter_cat'>Tampilkan Kategori :</label><select name='filter_cat' id='filter_cat' onchange="refreshList();">
	<option value='0' <?php if ($_filter <= 0) echo 'selected';?>>Semua</option>
	<?php foreach($_cats as $_cat) { ?>
		<option <?php
			echo "value='". $_cat->f_id ."'";
			if (isset($_filter))
				if ($_cat->f_id == $_filter) echo " selected"; ?>><?php echo $_cat->f_name; ?></option>
	<?php } ?>
</select> -->

<a href='#' class='button_admin btn_add' onclick="return new_docs();">Unggah baru</a>
<br><br>
<div style='min-height: 800px;'>
	<table class='table_list display' id='adm_docs_table'>
		<thead>
			<tr class='tb_head'><td>#</td><td>Filename</td><td>Tanggal Upload</td><td>Pembuat</td><td style="width:55px;">Hits</td></tr>
		</thead>
		<tbody>
			<?php
			$itemCounter = 1;
			foreach($listDocuments as $itemDoc) {
				$docDirectLink = base_url($itemDoc->f_file_path);
				echo "<tr>";
				echo "<td style=\"width: 48px;\"><img src=\"".base_url("/assets/images/icons/ico_pdf.png")."\" alt=\"File #".$itemCounter."\" /></td>";
				echo "<td><a href=\"".$docDirectLink."\"><b>".htmlspecialchars($itemDoc->f_name)."</b></a>\n";
				echo "<div class=\"tb_row_panel\">";
				echo "Direct Link: <b>".$docDirectLink."</b> <a href=\"#\"><i class=\"site_icon-link-1\"></i> Copy</a><div>\n";
				echo "<a href=\"#\"><i class=\"site_icon-info\"></i> Detil</a> | ";
				echo "<a href=\"#\"><i class=\"site_icon-link-1\"></i> Lihat Link</a> | ";
				echo "<a href=\"#\" onclick=\"return delete_doc(".$itemDoc->f_id.");\"><i class=\"site_icon-trash\"></i> Hapus</a></div></div>";
				echo "</td>";
				echo "<td>".($itemDoc->f_date_submit)."</td>";
				echo "<td>".($itemDoc->f_creator)."</td>";
				echo "<td>".($itemDoc->f_hits)."</td>";
				echo "</tr>\n";
				$itemCounter++;
			} ?>
		</tbody>
	</table>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery.datatables.css'); ?>">
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="<?php echo base_url('/assets/js/jquery.datatables.min.js'); ?>"></script>
<script>
var tableHandle;

var ajaxDataURL = "<?php //echo $urlAjaxRequest; ?>";
var ajaxActURL = "<?php echo base_url('/admin/media/ajax'); ?>";

function new_docs() {
	var formTitle = "Unggah Dokumen Baru";
	show_form_overlay("media","docs.getform", -1, formTitle);
	return false;
}

function delete_doc(idDoc) {
	if (is_processing) return false;
		
	var _conf = confirm("Hapus item yang Anda pilih?");
	if (_conf == false) return false;
	processed_id = idDoc;
	
	var _act_ = "docs.delete";
	_ajax_send(ajaxActURL, {
		act: _act_,
		id: idDoc
	}, 'Memproses...', function() {
		location.reload();
	}, true);
	return false;
}
$(document).ready(function () {
    tableHandle = $('#adm_docs_table').DataTable({
		processing: false,
		"aoColumnDefs": [
			{ 'bSortable': false, 'aTargets': [ 0, 3 ] }
		],
		"order": [[ 2, "desc" ]],
		"pageLength": 25
	});
	$("#filter_cat").change(function(){
		refreshList();
	});
});
</script>