<script>
var is_processing = false;
function savelinks_pub() {
	if (is_processing) return;
	
	var frmdata = $("#form_link_pub").serialize();
	$.ajax({
		type: "POST",
		url: "<?php echo base_url('/admin/links/updatelinks_pub'); ?>",
		data: frmdata,
		dateType: "string",
		beforeSend: function( xhr ) {
			is_processing = true;
			$("#btnpub_save").attr('disabled',true);
			$("#btnunpub_save").attr('disabled',true);
			show_overlay('Menyimpan...');
			$("#savestat_pub").html('Memproses...');
		},
		success: function(response){
			var result = $.trim(response);
			if(result === "OK") {
				$("#savestat_pub").html('Tersimpan! Halaman akan di<i>refresh</i> beberapas saat lagi...');
				location.reload(true);
			} else {
				$("#savestat_pub").html('Operasi menyimpan gagal!');
				alert('Operasi gagal: '+result);
			}
		},
		error: function(xhr){
			$("#savestat_pub").html('-');
			alert("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
		}
	}).always(function() {
		$("#btnpub_save").removeAttr('disabled');
		$("#btnunpub_save").removeAttr('disabled');
		is_processing = false;
		hide_overlay();
	});
}
function savelinks_unpub() {
	if (is_processing) return;
	var frmdata = $("#form_link_unpub").serialize();
	$.ajax({
		type: "POST",
		url: "<?php echo base_url('/admin/links/updatelinks_unpub'); ?>",
		data: frmdata,
		dateType: "string",
		beforeSend: function( xhr ) {
			is_processing = true;
			$("#btnpub_save").attr('disabled',true);
			$("#btnunpub_save").attr('disabled',true);
			$("#savestat_unpub").html('Memproses...');
			show_overlay('Menyimpan...');
		},
		success: function(response){
			var result = $.trim(response);
			if(result === "OK") {
				$("#savestat_unpub").html('Tersimpan! Halaman akan di<i>refresh</i> beberapas saat lagi...');
				location.reload(true);
			} else {
				$("#savestat_unpub").html('Operasi menyimpan gagal!');
				alert('Operasi gagal: '+result);
			}
		},
		error: function(xhr){
			$("#savestat_unpub").html('-');
			alert("Terjadi kesalahan: "+xhr.status + " " + xhr.statusText);
		}
	}).always(function() {
		$("#btnpub_save").removeAttr('disabled');
		$("#btnunpub_save").removeAttr('disabled');s
		is_processing = false;
		hide_overlay();
	});
}
</script>
<style>
.row_unpublished {
	background-color: #CECECE;
}
</style>

<h2>Daftar Tautan<h2>
<h3>Published Links:</h3>
<a href='<?php echo base_url('/admin/links/newlink'); ?>' class='button_admin btn_add'>Tambahkan tautan baru &raquo;</a>

<form action='<?php echo base_url('/admin/links/newlink'); ?>' id='form_link_pub'>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Prioritas</td><td>Aksi</td></tr>
<?php
$link_ctr = 0;
foreach($_links_pub as $_link) {
	$link_ctr++;
	echo "<tr".($link_ctr%2==0?" class='tb_row_2'":'').">";
	echo "<td>{$link_ctr}</td><td><a href='".base_url("/admin/links/editlink/{$_link->f_id}/")."' title='".htmlentities($_link->f_url)."'>{$_link->f_name}</a></td>";
	echo "<td><input type='text' size='3' value='{$_link->f_order}' name='order_[{$_link->f_id}]' /></td>";
	echo "<td><input type='checkbox' id='chk_{$_link->f_id}' name='hide_[{$_link->f_id}]' value='1'/><label for='chk_{$_link->f_id}'>Sembunyikan</label></td>";
	echo "</tr>\n";
} ?>
<tr class='tb_head'>
	<td colspan='4'><input type='button' class='button_admin btn_save' value='Simpan' onclick='savelinks_pub();' id='btnpub_save'/>
		<span id='savestat_pub'>-</span>
	</td>
</tr>
</table>
</form>
<h3>Unpublished Links:</h3>
<form action='/admin/links/updatelinks_unpub' id='form_link_unpub'>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Prioritas</td><td>Aksi</td></tr>
<?php
$link_ctr = 0;
foreach($_links_unpub as $_link) {
	$link_ctr++;
	echo "<tr class='row_unpublished'>";
	echo "<td>{$link_ctr}</td><td><a href='".base_url("/admin/links/editlink/{$_link->f_id}/")."' title='".htmlentities($_link->f_url)."'>{$_link->f_name}</a></td>";
	echo "<td><input type='text' size='3' value='{$_link->f_order}' name='order_[{$_link->f_id}]' /></td>";
	echo "<td><input type='checkbox' id='chk_{$_link->f_id}' name='show_[{$_link->f_id}]' value='1'/><label for='chk_{$_link->f_id}'>Publikasikan</label></td>";
	echo "</tr>\n";
} ?>
<tr class='tb_head'>
	<td colspan='4'><input type='button' class='button_admin btn_save' value='Simpan' onclick='savelinks_unpub();' id='btnunpub_save' />
		<span id='savestat_unpub'>-</span>
	</td>
	
</tr>
</table>
</form>