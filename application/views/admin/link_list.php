<ul>
<?php foreach($_links as $_link) { ?>
	<li><a href='/admin/editlink/<?php echo $_link->f_id; ?>/'><?php echo $_link->f_name; ?></a></li>
<?php } ?>
</ul>