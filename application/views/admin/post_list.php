<script>
function refreshList() {
	var cat_id	= $("select[name='filter_cat'] option:selected").index();
	var ipp		= $("#page_items").val();
	window.location.href = "?cat="+cat_id+"&n="+ipp;
}
</script>

<h2><?php if (isset($content_title)) echo $content_title; else echo "Posting Baru"; ?></h2>
<h3>Pending Drafts:</h3>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Action</td></tr>
<?php
 $_ctr_draft = 0;
 foreach($_drafts as $_draft) {
	echo "<tr>";
	echo "<td>$_ctr_draft</td><td><a href='/admin/".(($_draft->f_origin>0)?"editpost/".$_draft->f_origin:"newpost/".$_draft->f_id)."/'>";
	if (!empty($_draft->f_title)) echo $_draft->f_title; else echo "[Untitled]";
	echo "</a></td><td><a href='#'>Publish</a> - <a href='#'>Hapus</a></td>";
	echo "</tr>\n";
	$_ctr_draft++;
 }
?>
</table>
<h3>Website Posts:</h3>
<select name='filter_cat' id='filter_cat' onchange="refreshList();">
	<option value='0' <?php if ($_filter <= 0) echo 'selected';?>>Semua</option>
	<?php foreach($_cats as $_cat) { ?>
		<option <?php
			echo "value='".$_cat->f_id."'";
			if (isset($_filter))
				if ($_cat->f_id == $_filter) echo " selected"; ?>><?php echo $_cat->f_name; ?></option>
	<?php } ?>
</select>
<label for='page_items'>Per halaman:</label>
<select name='page_items' id='page_items' onchange="refreshList();">
<?php
	$nlist = array(10, 20, 30);
	foreach ($nlist as $nmode) {
		echo '<option';
		if ($nmode == $_ipp) echo ' selected';
		echo '>'.$nmode.'</option>\n';
	}
?>
<!--	<option value='10' selected>10</option>
	<option value='20'>20</option>
	<option value='30'>30</option>
	<option value='-1'>-</option> -->
</select>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Action</td></tr>
<?php
 if (!isset($_ctr)) $_ctr = 0; // counter
 foreach($_posts as $_post) {
	$_ctr++;
	echo "<tr".($_ctr%2==0?' class="tb_row_2"':'').">";
	echo "<td>$_ctr</td><td><a href='/admin/editpost/{$_post->id_berita}/'>{$_post->judul}</a></td>";
	echo "<td><a href='#'>Unpublish</a> - <a href='#'>Hapus</a></td>";
	echo "</tr>\n";
 }
?>
</table>
<div class='site_list_nav'>
	<?php if (isset($_paging)) echo $_paging; ?>
	<!-- <span>&laquo; First</span><span>&lt; Prev</span><span>...</span>
	<a href='#'>1</a><span>2</span><span>3</span><span>4</span><span>5</span>
	<span>...</span><span>Next &gt;</span><span>Last &raquo;</span> -->
</div>