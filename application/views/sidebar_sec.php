
	<div class='site_panel'>
		<div class='site_panel_head'>Artikel Terbaru</div>
		<div class='site_panel_body'>
			<ol>
				<?php	foreach($other_posts as $o_post) { ?>		
						<li class="link_news_unit">
							<span class="d_m_y_h_news"><?php echo date('j F Y, H:i',strtotime($o_post->tanggal) );?></span><br>
							<a href='/news/<?php echo $o_post->id_berita.'/'.$o_post->f_slug; ?>'><?php echo $o_post->judul; ?> </a></li>
				<?php } ?>
			  </ol>
		</div>
	</div>
	<div class='site_panel'>
		<div class='site_panel_head'>Tautan</div>
		<div class='site_panel_body'>
			<ul>
			<?php
					foreach($daftar_tautan as $_tautan){
			?>
					<li class="link_unit"><a href="<?php echo $_tautan->f_url; ?>"><?php  echo $_tautan->f_name; ?></a></li>
			   <?php } ?>
			   </ul>
		</div>
	</div>