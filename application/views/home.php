
	<div id='site_content_slider'>
		<div class='site_slider_wrapper'>
			<div class="pix_diapo">
				<div>
					<img style="width:100%; min-width:300px" src="assets/media/hmif2013ss.jpg" alt='Gambar banner 1'>
					<div class="caption elemHover fromLeft">
						Himpunan Mahasiswa Informatika (HMIF) UNDIP<br>
						<a href='http://hm.if.undip.ac.id' style='color: white'>http://hm.if.undip.ac.id</a>
						<!--Tak ada yang sia - sia. Sekeceil apapun usaha yang kita lakukan pasti akan membuahkan hasil.-->
					</div>
				</div>									
				<div>
					<img style="width:100%; min-width:300px" src="assets/media/labkomb.jpg" alt='Gambar banner 2'>
					<div class="caption elemHover fromLeft">
						Profesionalisme kami dedikasikan untuk menjamin mutu
					</div>
				</div>									
				<div>
					<img style="width:100%; min-width:300px" src="assets/media/labkomf.jpg" alt='Gambar banner 3'>
					<div class="elemHover caption fromLeft">
						Kedisiplinan mengantarkan pada keteraturan hidup, menciptakan kesuksesan
					</div>
				</div>
		   </div><!-- #pix_diapo -->
	   </div>
	</div>
	<div id='site_content_article'>
		<div class='site_news_wrapper'>
			<h3><?php echo "<a href='/news/".$newest_post[0]->id_berita."/{$newest_post[0]->f_slug}'>".$newest_post[0]->judul."</a>"; ?></h3>
			<?php echo substr(strip_tags($newest_post[0]->isi_berita),0,450) . "..."; ?>
			<div class='divclear'></div>
			<p><?php echo "<a href='/news/".$newest_post[0]->id_berita."/{$newest_post[0]->f_slug}' class='news_readmore'>Baca Selengkapnya &raquo;</a>"; ?></p>
			<div class='divclear'></div>
		</div>
		<div class='site_news_wrapper'>
			Berita terbaru lain:
			<ul>
				<?php
					if (count($newest_post)>1) {
						for ($_ctr=1; $_ctr < count($newest_post); $_ctr++) { ?>
				<li><a href='/news/<?php echo $newest_post[$_ctr]->id_berita; ?>/<?php echo $newest_post[$_ctr]->f_slug; ?>'><?php echo $newest_post[$_ctr]->judul; ?></a></li>
				<?php } // end for
					} // end if
				 ?>
			</ul>
			<a href='/news/' class='news_readmore'>Berita Selengkapnya &raquo;</a>
			<div class='divclear'></div>
		</div>
	</div>
	<div id='site_content_more'>
		<div id="container">
			<select class='menu_tab_mini'>
				<option id='tab_mini_1' class='active'>Akademik</option>
				<option id='tab_mini_2'>Pendidikan</option>
				<option id='tab_mini_3'>Penelitian</option>
				<option id='tab_mini_4'>Lowongan</option>
				<option id='tab_mini_5'>Beasiswa</option>
			</select>
			<ul class="menu_tab">
				<li id="tab_1" class="active">Akademik</li>
				<li id="tab_2">Pendidikan</li>
				<li id="tab_3">Penelitian</li>
				<li id="tab_4">Lowongan</li>
				<li id="tab_5">Beasiswa</li>
			</ul>
			<span class="clear"></span>
			<div class="content tab_1"><?php
				if (count($other_posts[0])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[0] as $o_post) {
						echo "<li><a href='news/{$o_post->id_berita}/{$o_post->f_slug}'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_2"><?php
				if (count($other_posts[1])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[1] as $o_post) {
						echo "<li><a href='news/{$o_post->id_berita}/{$o_post->f_slug}'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_3"><?php
				if (count($other_posts[2])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[2] as $o_post) {
						echo "<li><a href='news/{$o_post->id_berita}/{$o_post->f_slug}'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_4"><?php
				if (count($other_posts[3])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[3] as $o_post) {
						echo "<li><a href='news/{$o_post->id_berita}/{$o_post->f_slug}'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
			<div class="content tab_5"><?php
				if (count($other_posts[4])==0) echo "Tidak ada berita.";
				else {
					echo "<ul>\n";
					foreach($other_posts[4] as $o_post) {
						echo "<li><a href='news/{$o_post->id_berita}/{$o_post->f_slug}'>{$o_post->judul}</a></li>\n";
					}
					echo "</ul>\n";
				} ?></div>
		</div>
	</div>
