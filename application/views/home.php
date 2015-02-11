
	<div id='site_content_slider'>
		<div class='site_slider_wrapper'>
			<div class="pix_diapo">
			<?php
			$_slidectr = 0;
			foreach ($_homeslides as $_slide) {
				$_slidectr++;
				echo "<div>\n";
				echo "	<img style=\"width:680px; height: 250px; min-width:300px\" src=\"".base_url($_slide->f_url)."\" alt='Gambar banner {$_slidectr}'>\n";
				echo "	<div class=\"caption elemHover fromLeft\">".($_slide->f_desc)."</div>\n";
				echo "</div>\n";
			}
			?>
		   </div><!-- #pix_diapo -->
	   </div>
	</div>
	<div id='site_content_article'>
		<div class='site_news_wrapper'>
			<h2><?php echo "<a href='".base_url("/news/".$newest_post[0]->id_berita."/{$newest_post[0]->f_slug}")."'>".$newest_post[0]->judul."</a>"; ?></h2>
			<?php echo "<div class='site_news_metadate'>Diposting oleh {$newest_post[0]->creator} tanggal ".date('j F Y, H:i',strtotime($newest_post[0]->tanggal))."</div>"; ?>
			<!-- <img style='width: 100px; height: auto;' src='<?php echo base_url('/assets/images/index.jpg'); ?>' alt='Gambar1' align='left'/> -->
			<p><?php echo substr(strip_tags($newest_post[0]->isi_berita),0,450) . "..."; ?><p>
			<div class='divclear'></div>
			<p><?php echo "<a href='".base_url("/news/".$newest_post[0]->id_berita."/{$newest_post[0]->f_slug}")."' class='news_readmore'>Baca Selengkapnya &raquo;</a>"; ?></p>
			<div class='divclear'></div>
		</div>
		<div class='site_news_wrapper'>
			Berita terbaru lain:
			<ul>
				<?php
					if (count($newest_post)>1) {
						for ($_ctr=1; $_ctr < count($newest_post); $_ctr++) { ?>
				<li><a href='<?php echo base_url("/news/{$newest_post[$_ctr]->id_berita}/{$newest_post[$_ctr]->f_slug}"); ?>'><?php echo $newest_post[$_ctr]->judul; ?></a></li>
				<?php } // end for
					} // end if
				 ?>
			</ul>
			<a href='<?php echo base_url('/news/'); ?>' class='news_readmore'>Berita Selengkapnya &raquo;</a>
			<div class='divclear'></div>
		</div>
	</div>
	<div id='site_content_more'>
		<div id="container">
			<select class='menu_tab_mini'>
				<option id='tab_mini_1' class='active'>Akademik</option>
				<option id='tab_mini_2'>Berita IT</option>
				<option id='tab_mini_3'>Lowongan</option>
				<option id='tab_mini_4'>Penelitian</option>
				<option id='tab_mini_5'>Beasiswa</option>
			</select>
			<ul class="menu_tab">
				<li id="tab_1" class="active">Akademik</li>
				<li id="tab_2">Berita IT</li>
				<li id="tab_3">Lowongan</li>
				<li id="tab_4">Penelitian</li>
				<li id="tab_5">Beasiswa</li>
			</ul>
			<span class="clear"></span>
			<div class="content tab_1"><?php
				if (count($other_posts[0])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[0] as $o_post) {
						echo "<li><a href='".base_url("/news/{$o_post->id_berita}/{$o_post->f_slug}")."'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_2"><?php
				if (count($other_posts[1])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[1] as $o_post) {
						echo "<li><a href='".base_url("/news/{$o_post->id_berita}/{$o_post->f_slug}")."'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_3"><?php
				if (count($other_posts[2])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[2] as $o_post) {
						echo "<li><a href='".base_url("/news/{$o_post->id_berita}/{$o_post->f_slug}")."'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_4"><?php
				if (count($other_posts[3])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[3] as $o_post) {
						echo "<li><a href='".base_url("/news/{$o_post->id_berita}/{$o_post->f_slug}")."'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_5"><?php
				if (count($other_posts[4])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[4] as $o_post) {
						echo "<li><a href='".base_url("/news/{$o_post->id_berita}/{$o_post->f_slug}")."'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
		</div>
	</div>
