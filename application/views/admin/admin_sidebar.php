<ul id="admin_sidebar_nav">
<?php
	// Dasbor adalah mutlak
	echo "<li><a href=\"".base_url('/admin/dashboard')."\"><i class=\"site_icon-home\"></i> Dasbor</a></li>\n";
	
	// ambil nilai flag role user
	$__uprev = $this->nativesession->get('user_role_');
	
	// cek previlege untuk user...
	if ($__uprev & 2) {
		echo "<li><a href=\"".base_url('/admin/posts')."\"><i class=\"site_icon-list\"></i> Daftar Posting</a></li>\n";
		echo "<li><a href=\"".base_url('/admin/posts/newpost')."\" style=\"margin-left: 24px;\"><i class=\"site_icon-pencil\"></i> Tulis Post baru</a></li>\n";
	}
	if ($__uprev & 256)	echo "<li><a href=\"".base_url('/admin/pengumuman')."\"><i class=\"site_icon-pencil\"></i> Tulis Pengumuman</a></li>\n";
	if ($__uprev & 2)	echo "<li><a href=\"".base_url('/admin/posts/categories')."\"><i class=\"site_icon-list\"></i> Atur Kategori Posting</a></li>\n";
	if ($__uprev & 8)	echo "<li><a href=\"".base_url('/admin/events')."\"><i class=\"site_icon-calendar\"></i> Event Organizer</a></li>\n";
	if ($__uprev & 16)	echo "<li><a href=\"".base_url('/admin/links')."\"><i class=\"site_icon-list\"></i> Daftar Tautan</a></li>\n";
	if ($__uprev & 128)	echo "<li><a href=\"".base_url('/admin/staff')."\"><i class=\"site_icon-list\"></i> Daftar Staff</a></li>\n";
	if ($__uprev & 32)	{
		echo "<li><a href=\"".base_url('/admin/media')."\"><i class=\"site_icon-list\"></i> Media</a></li>\n";
		echo "<li><a href=\"".base_url('/admin/media/album')."\" style=\"margin-left: 24px;\"><i class=\"site_icon-picture\"></i> Album Galeri</a></li>\n";
		echo "<li><a href=\"".base_url('/admin/media/docs')."\" style=\"margin-left: 24px;\"><i class=\"site_icon-picture\"></i> Dokumen</a></li>\n";
	}
	if ($__uprev & 4)	echo "<li><a href=\"".base_url('/admin/pages')."\"><i class=\"site_icon-list\"></i> Daftar Halaman</a></li>\n";
	if ($__uprev & 64)	echo "<li><a href=\"".base_url('/admin/slider')."\"><i class=\"site_icon-picture\"></i> Atur Gambar slider</a></li>\n";
	//	echo "<!-- <li><a href=\"/admin/menu\">Manage Menu</a></li> -->\n";
	if ($__uprev & 1)	echo "<li><a href=\"".base_url('/admin/users')."\"><i class=\"site_icon-user\"></i> Daftar User</a></li>\n";

?></ul>
<div class='divclear'></div>
<div style="padding: 10px; border: solid 1px #ccc; text-align: center; margin: 10px; background-color:#FFFFFF;">
	<strong>IF UNDIP CMS v.1.10.1</strong><br>
	<small>Date 7 Februari 2015 [<a href='<?php echo base_url('/admin/system/changelog'); ?>'>Changelog</a>]</small>
</div>