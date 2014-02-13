<script>
function refreshList() {
	var cat_id	= $("select[name='filter_cat'] option:selected").index();
	var ipp		= $("#page_items").val();
	window.location.href = "?cat="+cat_id+"&n="+ipp+"#posts";
}
function unpublish
</script>

<h2><?php if (isset($content_title)) echo $content_title; else echo "Daftar Posting"; ?></h2>
<h3>Pending Drafts:</h3>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Action</td></tr>
<?php
 $_ctr_draft = 1;
 foreach($_drafts as $_draft) {
	echo "<tr>";
	echo "<td>$_ctr_draft</td><td><a href='/admin/posts/".(($_draft->f_origin>0)?"editpost/".$_draft->f_origin:"newpost/".$_draft->f_id)."/'>";
	if (!empty($_draft->f_title)) echo $_draft->f_title; else echo "[Untitled]";
	echo "</a></td><td><a href='#'><img src='/assets/images/admin/admin_pub.png' alt='Publish - ' class='img_icon' title='Publish'/></a> ";
	echo "<a href='#'><img src='/assets/images/admin/admin_del.png' alt='Hapus' class='img_icon' title='Hapus'/></a></td>";
	echo "</tr>\n";
	$_ctr_draft++;
 }
?>
</table>
<h3 id='posts'>Website Posts:</h3>
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
?></select>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Action</td></tr>
<?php
 if (!isset($_ctr)) $_ctr = 0; // counter
 $_ctr_post = 1;
 foreach($_posts as $_post) {
	$_ctr++;
	echo "<tr".($_ctr_post%2==0?' class="tb_row_2"':'').">";
	echo "<td>$_ctr</td><td><a href='/admin/posts/editpost/{$_post->id_berita}/'>{$_post->judul}</a></td>";
	echo "<td><a href='#'><img src='/assets/images/admin/admin_unpub.png' alt='Unpublish -' class='img_icon' title='Unpublish'/></a> ";
	echo "<a href='#'><img src='/assets/images/admin/admin_del.png' alt='Hapus' class='img_icon' title='Hapus'/></a></td>";
	echo "</tr>\n";
	$_ctr_post++;
 }
?>
</table>
<div class='site_list_nav'>
	<?php if (isset($_paging)) echo $_paging; ?>
</div>