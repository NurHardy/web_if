<h2><?php if (isset($content_title)) echo $content_title; else echo "Daftar Pengguna"; ?></h2>
<h3>Daftar Pengguna:</h3>
<hr>
<a href='<?php echo base_url('/admin/users/newuser'); ?>' class='button_admin btn_add'>Buat baru &raquo;</a>
<table class='table_list'>
<tr class='tb_head'><td style='width: 32px;'>#</td><td>Username</td>
	<td>Nama Lengkap</td><td>E-mail</td><td>Login Terakhir</td>
	<td style='width: 200px;'>Action</td></tr>
<?php
 $_ctr_user = 1;
 foreach($_users as $_user) {
	if ($_ctr_user %2 == 1) echo "<tr>";
	else echo "<tr class='tb_row_2'>";
	echo "<td>$_ctr_user</td><td><a href='".base_url('/admin/users/edituser/'.$_user->f_id.'/')."'>";
	if (!empty($_user->f_username)) echo $_user->f_username; else echo "[Untitled]";
	echo "</a></td><td>{$_user->f_fullname}</td><td><a href='mailto:{$_user->f_email}'>{$_user->f_email}</a></td>";
	echo "<td>{$_user->f_date_last}</td><td><a href='".base_url("/admin/users/changeauth/{$_user->f_id}")."'>Ganti password</a> - <a href='#'>Edit</a> - <a href='#'>Hapus</a></td>";
	echo "</tr>\n";
	$_ctr_user++;
 }
?>
</table>
<div class='site_list_nav'>
	<?php if (isset($_paging)) echo $_paging; ?>
</div>