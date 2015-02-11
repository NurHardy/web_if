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

<a href='#' class='button_admin btn_add'>Unggah baru</a>
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
				echo "<tr>";
				echo "<td>".$itemCounter."</td>";
				echo "<td>".htmlspecialchars($itemDoc->f_name);
				echo "\n<div class=\"tb_row_panel\"><div>";
				echo "<a href=\"#\"><i class=\"site_icon-info\"></i> Detil</a> | ";
				echo "<a href=\"#\"><i class=\"site_icon-link-1\"></i> Lihat Link</a> | ";
				echo "<a href=\"#\"><i class=\"site_icon-trash\"></i> Hapus</a></div></div>";
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
var ajaxActURL = "<?php echo base_url('/admin/posts/post_ajax_act'); ?>";

function refreshList() {
	var newCatFilter = parseInt($("#filter_cat").val());
	tableHandle.ajax.url(ajaxDataURL+"/"+newCatFilter).load(null, false);
}
function unpub(elmt, _id) {
	if (is_processing) return;
	//var _conf = confirm("Unpublish post "+_id+"?");
	//if (_conf == false) return false;
	processed_id = _id;
	_ajax_send(ajaxActURL,{
		_act: 'unpub',
		_postid: _id
	}, 'Memproses...', function() {
		refreshList();
	}, false);
	return false;
}
function post_pub(elmt, _id) {
	if (is_processing) return;
	//var _conf = confirm("Publish post "+_id+"?");
	//if (_conf == false) return false;
	processed_id = _id;
	_ajax_send(ajaxActURL,{
		_act: 'pub',
		_postid: _id
	}, 'Mempublikasikan...', function() {
		refreshList();
	}, false);
	return false;
}
function delpost(elmt, _id) {
	var _title = "JUDUL";
	
	var itemRow = $(elmt).closest('tr');
	var itemTitle = itemRow.find('td:first');
	itemTitle.css('border-left','solid 5px #f00');
	
	_title = itemRow.find('span.p_title').html();
	var _conf = confirm("Hapus posting \""+_title+"\"?");
	itemTitle.css('border-left','none');
	
	if (_conf == false) return false;
	processed_id = _id;
	
	_ajax_send(ajaxActURL,{
		_act: 'del_',
		_postid: _id
	}, 'Menghapus posting...', function() {
		refreshList();
	}, false);
	return false;
}
function deldraft(elmt, _id) {
	var _title = "JUDUL";
	
	var itemRow = $(elmt).closest('tr');
	var itemTitle = itemRow.find('td:first');
	itemTitle.css('border-left','solid 5px #f00');
	
	var _conf = confirm("Hapus draf "+_id+"?");
	itemTitle.css('border-left','none');
	
	if (_conf == false) return false;
	processed_id = _id;
	_ajax_send(ajaxActURL,{
		_act: 'canceldraft',
		_draftid: _id
	}, 'Menghapus draf...', function() {
		location.reload(true);
	}, false);
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