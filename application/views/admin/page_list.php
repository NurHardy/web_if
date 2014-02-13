<script>
function refreshList() {
	var ipp		= $("#page_items").val();
	window.location.href = "?n="+ipp;
}
</script>

<h2><?php if (isset($content_title)) echo $content_title; else echo "Daftar Halaman"; ?></h2>
<h3>Website Pages:</h3>
<a href='/admin/pages/newpage'>Buat baru &raquo;</a>
<hr>
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
</select>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Judul</td><td style='width: 200px;'>Action</td></tr>
<?php
 if (!isset($_ctr)) $_ctr = 0; // counter
 foreach($_pages as $_page) {
	$_ctr++;
	echo "<tr".($_ctr%2==0?' class="tb_row_2"':'').">";
	echo "<td>$_ctr</td><td><a href='/admin/pages/editpage/{$_page->f_id}/'>{$_page->f_title}</a></td>";
	echo "<td><a href='#'><img src='/assets/images/admin/admin_unpub.png' alt='Unpublish -' class='img_icon' title='Unpublish'/></a>";
	echo "<a href='#'><img src='/assets/images/admin/admin_del.png' alt='Hapus' class='img_icon' title='Hapus'/></a></td>";
	echo "</tr>\n";
 }
?>
</table>
<div class='site_list_nav'>
	<?php if (isset($_paging)) echo $_paging; ?>
</div>
