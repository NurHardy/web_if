	<div id='site_content_article'>
		<h2 class='site_article_title'><?php echo $_posting[0]->judul; ?></h2>
		<small>Diposting oleh <?php echo $_posting[0]->creator; ?> pada <?php echo $_posting[0]->tanggal; ?></small>
		<hr>
		<?php echo $_posting[0]->isi_berita; ?><br>
	</div>
	<div id='site_content_more'>
		<ul>
		<?php
				foreach($other_posts as $o_post) {
		?>		<li><a href='/news/<?php echo $o_post->id_berita; ?>/'><?php echo $o_post->judul; ?></a></li>
		<?php } ?>
		</ul>
	</div>
	<div id="site_article_comment">
		<div class="fb-comments" data-href="http://localhost/" data-width="650" data-numposts="2" data-colorscheme="light"></div>
	</div>
