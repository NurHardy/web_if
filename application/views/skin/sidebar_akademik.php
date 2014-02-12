<div class='site_panel'>
		<div class='site_panel_head'>Akademik</div>
		<div class='site_panel_body'>
			<ol class='side_profil'>
				<li><a href='/page/perak'>Peraturan Akademik</a></li>
				<li><a href='/page/manual'>Manual Prosedur</a></li>
				<li><a href='/page/kalender'>Kalender Akademik</a></li>
				<li><a href='/kurikulum'>Kurikulum</a></li>
				<li><a href='/page/jadwal'>Jadwal Kuliah</a></li>
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