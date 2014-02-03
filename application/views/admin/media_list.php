<ul>
<?php foreach($_medias as $_media) { ?>
	<li><a href='<?php echo $_media->f_file_path; ?>'><?php echo $_media->f_name; ?></a></li>
<?php } ?>
</ul>
<a href='/admin/newmedia'>Unggah baru &raquo;</a>