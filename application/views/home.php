
	<div id='site_content_slider'>
		<div class='site_slider_wrapper'>
			<div class="pix_diapo">
				<div>
					<img style="width:100%; min-width:300px" src="assets/images/test_banner_1.jpg">
					<div class="caption elemHover fromLeft">
						Tak ada yang sia - sia. Sekeceil apapun usaha yang kita lakukan pasti akan membuahkan hasil.
					</div>
				</div>									
				<div>
					<img style="width:100%; min-width:300px" src="assets/images/test_banner_2.jpg">
					<div class="caption elemHover fromLeft">
						Profesionalisme kami dedikasikan untuk menjamin mutu
					</div>
				</div>									
				<div>
					<img style="width:100%; min-width:300px" src="assets/images/test_banner_3.jpg">
					<div class="elemHover caption fromLeft">
						Kedisiplinan mengantarkan pada keteraturan hidup, menciptakan kesuksesan
					</div>
				</div>
		   </div><!-- #pix_diapo -->
	   </div>
	</div>
	<!-- <div id="sosial_panel">
		<a href="#"><img class="sosial_icon" src="/assets/images/facebook_icon.png"></a>
		<a href="#"><img class="sosial_icon" src="/assets/images/twitter_icon.png"></a>
		<a href="#"><img class="sosial_icon" src="/assets/images/google_icon.png"></a>
		<a href="#"><img class="sosial_icon" src="/assets/images/rss_icon.png"></a>
		<img class='search_but' src='/assets/images/search_icon.png'><input class='search_box'type='text'></input>
	</div> -->
	<div id='site_content_article'>
		<h3><?php echo "<a href='/news/".$newest_post[0]->id_berita."'>".$newest_post[0]->judul."</a>"; ?></h3>
		<?php echo $newest_post[0]->isi_berita; ?>
		<hr>
		<?php echo "<a href='/news/".$newest_post[0]->id_berita."'>Baca Selengkapnya &raquo;</a>"; ?>
		<hr>
		Berita terbaru lain:
		<ul>
			<?php
				$_count_ = 1;
				foreach($other_posts as $o_post) {?>
			<li><a href='news/<?php echo $o_post->id_berita; ?>/'><?php echo $o_post->judul; ?></a></li>
			<?php } ?>
		</ul>
	</div>
	<div id='site_content_more'>
		<div id="container">
			<ul class="menu_tab">
				<li id="tab_1" class="active">Akademik</li>
				<li id="tab_2">Pendidikan</li>
				<li id="tab_3">Penelitian</li>
				<li id="tab_4">Lowongan</li>
				<li id="tab_5">Beasiswa</li>
			</ul>
			<span class="clear"></span>
			<div class="content tab_1">
				Akademik: Tidak ada yang dapat ditampilkan...
			</div>
			<div class="content tab_2">
				Pendidikan: Tidak ada yang dapat ditampilkan...
			</div>
			<div class="content tab_3">
				Penelitian: Tidak ada yang dapat ditampilkan...
			</div>
			<div class="content tab_4">
				Lowongan: Tidak ada yang dapat ditampilkan...
			</div>
			<div class="content tab_5">
				Beasiswa: Tidak ada yang dapat ditampilkan...
			</div>
		</div>
	</div>
