	<div id='site_content_article'>
		<?php foreach($_posts as $_post) { ?>
			<h2 class='site_article_title'><a href='<?php echo "/news/{$_post->id_berita}/{$_post->f_slug}"; ?>'><?php echo $_post->judul; ?></a></h2>
			<small>Diposting oleh <?php echo $_post->creator; ?> pada <?php echo $_post->tanggal; ?></small>
			<hr>
			<?php echo substr(strip_tags($_post->isi_berita),0,310) . "..."; ?><br>
		<?php } ?>
		<div class='site_list_nav'>
			<?php if (isset($_paging)) echo $_paging; ?>
		</div>
	</div>
