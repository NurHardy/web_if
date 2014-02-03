<ul>
<?php foreach($_posts as $_post) { ?>
	<li><a href='/admin/editpost/<?php echo $_post->id_berita; ?>/'><?php echo $_post->judul; ?></a></li>
<?php } ?>
</ul>