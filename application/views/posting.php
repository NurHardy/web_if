	<div id='site_content_article'>
		<h2 class='site_article_title'><?php echo $_posting->judul; ?></h2>
		<small>Diposting oleh <?php echo $_posting->creator; ?> pada <?php echo date('j F Y, H:i',strtotime($_posting->tanggal) ); ?></small>
		<hr>
		<?php echo $_posting->isi_berita; ?><br>
	</div>
	<div id='site_content_more'>
		<ul>
		<?php
				foreach($other_posts as $o_post) {
		?>		<li><a href='<?php echo base_url('/news');?>/<?php echo $o_post->id_berita.'/'.$o_post->f_slug; ?>'><?php echo $o_post->judul; ?></a></li>
		<?php } ?>
		</ul>
	</div>
<?php if (!isset($is_preview)) { ?>
	<div id="site_article_comment">
		<div class="fb-comments" data-href="<?php echo htmlentities(base_url("/news/{$_posting->id_berita}/{$_posting->f_fb_slug}")); ?>" data-numposts="2" data-colorscheme="light" style='width: 100%'></div>
	</div>
<?php } // end if ?>