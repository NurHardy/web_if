<h2><?php if (isset($content_title)) echo $content_title; else echo "Daftar Posting"; ?></h2>
<h3>Pending Drafts:</h3>
<small>Pending draft adalah draft posting yang belum dipublikasikan.</small>

<table class='table_list'>
	<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Action</td></tr>
	<?php
	 $_ctr_draft = 1;
	 foreach($_drafts as $_draft) {
		echo "<tr".($_ctr_draft%2==0?' class="tb_row_2"':'')." id='tb_row_d{$_draft->f_id}'>";
		echo "<td>$_ctr_draft</td><td><a href='".base_url('/admin/posts/'.(($_draft->f_origin>0)?"editpost/".$_draft->f_origin:"newpost/".$_draft->f_id))."/'>";
		if (!empty($_draft->f_title)) echo $_draft->f_title; else echo "[Untitled]";
		echo "</a></td><td><a href='".base_url('/admin/posts/'.(($_draft->f_origin>0)?"editpost/".$_draft->f_origin:"newpost/".$_draft->f_id))."' class='adm_row_btn c_col_grey c_img_edit'>Edit</a>\n";
		echo "<a href='#' onclick='return deldraft(this, {$_draft->f_id});' class='adm_row_btn c_col_red c_img_del'>Hapus Draft</a></td>";
		echo "</tr>\n";
		$_ctr_draft++;
	 }
	?>
</table>

<h3 id='posts'>Website Posts:</h3>
<label for='filter_cat'>Tampilkan Kategori :</label><select name='filter_cat' id='filter_cat' onchange="refreshList();">
	<option value='0' <?php if ($_filter <= 0) echo 'selected';?>>Semua</option>
	<?php foreach($_cats as $_cat) { ?>
		<option <?php
			echo "value='". $_cat->f_id ."'";
			if (isset($_filter))
				if ($_cat->f_id == $_filter) echo " selected"; ?>><?php echo $_cat->f_name; ?></option>
	<?php } ?>
</select>

<a href='<?php echo base_url('/admin/posts/newpost'); ?>' class='button_admin btn_add'>Buat baru &raquo;</a>
<div style='min-height: 800px;'>
	<table class='table_list display' id='adm_posting_table'>
		<thead>
			<tr class='tb_head'><td>Judul</td><td style='width: 55px;'>Hits</td><td>Tanggal</td><td style='width: 200px;'>Action</td></tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery.datatables.css'); ?>">
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="<?php echo base_url('/assets/js/jquery.datatables.min.js'); ?>"></script>
<script>
var tableHandle;

var ajaxDataURL = "<?php echo $urlAjaxRequest; ?>";
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
    tableHandle = $('#adm_posting_table').on('preXhr.dt', function ( e, settings, data ) {
			//data.sessionId = $('#sessionId').val();
			is_processing = true;
			show_overlay("Mengambil data...");
		} ).on( 'xhr.dt', function () {
			is_processing = false;
			hide_overlay();
		} ).DataTable({
		processing: true,
		ajax: {
			url: ajaxDataURL,
            dataSrc: "",
			data: {smt:0}
        },
        columns: [
            { data: {
                _:    "f_title.title_cell",
                sort: "f_title.title_val"
            } },
			{ data: "f_hits" },
			{ data: {
                _:    "f_created.created_cell",
                sort: "f_created.created_val"
            } },
            { data: "f_acts" }
        ],
		"aoColumnDefs": [
			{ 'bSortable': false, 'aTargets': [ 3 ] }
		],
		"order": [[ 2, "desc" ]],
		"pageLength": 10
	});
	$("#filter_cat").change(function(){
		refreshList();
	});
});
</script>