<h2><?php if (isset($content_title)) echo $content_title; else echo "Daftar Pengguna"; ?></h2>
<h3>Daftar Pengguna:</h3>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Username</td>
	<td>Nama Lengkap</td><td>E-mail</td>
	<td style='width: 200px;'>Action</td></tr>
<?php
 $_ctr_user = 1;
 foreach($_users as $_user) {
	echo "<tr>";
	echo "<td>$_ctr_user</td><td><a href='/admin/edituser/".$_user->f_id."/'>";
	if (!empty($_user->f_username)) echo $_user->f_username; else echo "[Untitled]";
	echo "</a></td><td>{$_user->f_fullname}</td><td>{$_user->f_email}</td><td><a href='#'>Edit</a> - <a href='#'>Hapus</a></td>";
	echo "</tr>\n";
	$_ctr_user++;
 }
?>
</table>
<div class='site_list_nav'>
	<?php if (isset($_paging)) echo $_paging; ?>
</div>