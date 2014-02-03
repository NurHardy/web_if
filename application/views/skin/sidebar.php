
	<div class='site_panel'>
		<div class='site_panel_head'>Agenda Terdekat</div>
		<div class='site_panel_body'>
			<ol>
			<?php
					$nama_bulan = array('Bul','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des');
					foreach($daftar_event as $_event){
			?>
					<li class="event_unit">
						<div class="date_event">
							<?php
								$bul = intval(date("m", strtotime($_event->f_date)));
								echo "<span class='month'>" .$nama_bulan[$bul]."</span><br>
							<span class='day'>".date("d", strtotime($_event->f_date))."</span>";?>
						</div>
						<div class="desc_event">
							<a href='#'><?php echo $_event->f_name; ?></a>
						</div>
					</li>
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
					<li class='link_unit'><a href="<?php echo $_tautan->f_url; ?>"><?php  echo $_tautan->f_name; ?></a></li>
			   <?php } ?>
			   </ul>
		</div>
	</div>
	<div class='site_panel'>
		<div class='site_panel_head'>Panel 3</div>
		<div class='site_panel_body'>
			Isi panel 3
		</div>
	</div>
