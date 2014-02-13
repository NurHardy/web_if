<h2><?php if (isset($content_title)) echo $content_title; else echo "Media terunggah"; ?></h2>
<a href='/admin/media/newmedia'>Unggah baru &raquo;</a>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Media</td><td style='width: 200px;'>Action</td></tr>

<?php
$_fctr = 1;
foreach($_medias as $_media) {
	if (($_fctr%2)==0) echo "<tr class='tb_row_2'>";
	else echo "<tr>";
	echo "<td>{$_fctr}</td>";
	if ($_media->f_file_type_id == 1) {
		echo "<td><a href='{$_media->f_file_path}'><img src='{$_media->f_file_path}' alt='{$_media->f_name}' title='{$_media->f_name}'";
		echo " style='width: 200px; height: auto;' /></a>\n";
	} else {
		echo "<td><a href='{$_media->f_file_path}'>{$_media->f_name}</a>\n";
	}
	echo "<input type='text' readonly value='".htmlentities(base_url($_media->f_file_path))."' style='width: 100%;'/></td>";
	echo "<td><a href='#'><img src='/assets/images/admin/admin_del.png' alt='Hapus' class='img_icon' title='Hapus'/></a></td>";
	echo "</tr>\n";
	$_fctr++;
}
?>
</table>
