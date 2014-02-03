<ul>
<?php foreach($_pages as $_page) { ?>
	<li><a href='/admin/editpage/<?php echo $_page->f_id; ?>/'><?php echo $_page->f_title; ?></a></li>
<?php } ?>
</ul>
<a href='/admin/newpage'>Buat baru &raquo;</a>