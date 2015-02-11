<!--<div class='site_panel'>
		<div class='site_panel_head'>Profil</div>
		<div class='site_panel_body'>
			<ol class='side_profil'>
				<li><a href='<?php echo base_url('/page/sejarah');?>'>Sejarah</a></li>
				<li><a href='<?php echo base_url('/page/visi-misi');?>'>Visi Misi</a></li>
				<li><a href='<?php echo base_url('/struktur_organisasi');?>'>Struktur Organisasi</a></li>
				<li><a href='<?php echo base_url('/staff');?>'>Staff</a></li>
				<li><a href='<?php echo base_url('/page/kerjasama');?>'>Kerjasama</a></li>
			  </ol>
		</div>
	</div>
		-->
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