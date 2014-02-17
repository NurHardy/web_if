	<div id='site_content_article'>
		<?php foreach($_posts as $_post) { ?>
		<div style='padding: 5px;'>
			<h2 class='site_article_title'><a href='<?php echo "/news/{$_post->id_berita}/{$_post->f_slug}"; ?>'><?php echo $_post->judul; ?></a></h2>
			<small>Diposting oleh <?php echo $_post->creator; ?> pada <?php echo date('j F Y, H:i',strtotime($_post->tanggal) ); ?></small>
			<hr>
			<?php
			$_striptag = substr(strip_tags($_post->isi_berita),0,310);
			echo $_striptag . "...";
			if (strlen($_striptag) > 300) echo "<div class='site_news_foot'><a href='/news/{$_post->id_berita}/{$_post->f_slug}'>Baca selengkapnya &raquo;</a></div>";
			?>
		</div>
		<?php } ?>
		<div class='site_list_nav'>
			<?php if (isset($_paging)) echo $_paging; ?>
		</div>
	</div>
