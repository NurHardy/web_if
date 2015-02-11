
	<div class='site_panel'>
		<div class='site_panel_head'>Agenda Terdekat</div>
		<div class='site_panel_body'>
			<ol>
			<?php
					$nama_bulan = array('Bul','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des');
					if (empty($daftar_event)) {
						echo "<p>Tidak ada agenda terdekat...</p>";
					} else {
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
							<a href='<?php echo base_url('/agenda');?>'><?php echo $_event->f_name; ?></a>
						</div>
					</li>
			   <?php } // end foreach
				} // end if ?>
			   </ol>
		</div>
	</div>
	<!-- pengumuman -->
	<div class='site_panel'>
		<div class='site_panel_head'>Pengumuman</div>
		<div class='site_panel_body'>
			<ul>
				<?php if(empty($daftar_pengumuman)){
					echo "<li><p>Tidak ada pengumuman...</p></li>";
					} else {
					$count=1;
					foreach($daftar_pengumuman as $_daftar_pengumuman){
					if ($count%2==1){
				?>
				
				<li class="event_unit" style='max-width:230px;padding:5px;margin-bottom:5px;background-color:#97BEDB'><strong><?php  echo $_daftar_pengumuman->judul; ?></strong><br><hr></hr><small><?php  echo $_daftar_pengumuman->isi; ?></small></li>
				<?php }
					else if($count%2==0){ ?>
				<li class="event_unit" style='max-width:230px;padding:5px;margin-bottom:5px; background-color:#AEDDF9'><strong><?php  echo $_daftar_pengumuman->judul; ?></strong><br><hr></hr><small><?php  echo $_daftar_pengumuman->isi; ?></small></li>
				<?php }
				$count++;}}?>
			</ul>
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
		<div class='site_panel_head'>Partner</div>
		<div class='site_panel_body'>
			<div id='partner_mini'>
				<a href='https://academy.oracle.com/'><img src='<?php echo base_url('/assets/images/oracle.png');?>' class='site_partner' alt='Oracle Academy'/></a>
				<a href='http://www.msdnaa.undipcyber.us/'><img src='<?php echo base_url('/assets/images/msdnaa.png');?>' class='site_partner' alt='MSDN Academic Alliance'/></a>
			</div>
			<div id="divTrigger">
				 <a href="javascript:;" onClick="openContent(this,'div1')" id="firstSlide">1</a>
				 <a href="javascript:;" onClick="openContent(this,'div2')">2</a>
			</div>
				 
			<div id="divContent">
				<div id="div1">
					<a href='https://academy.oracle.com/'><img src='<?php echo base_url('/assets/images/oracle.png');?>' class='site_partner' alt='Oracle Academy'/></a>
				</div>
				<div id="div2">
					<a href='http://www.msdnaa.undipcyber.us/'><img src='<?php echo base_url('/assets/images/msdnaa.png');?>' class='site_partner' alt='MSDN Academic Alliance'/></a>
				 </div>
			</div>
		</div>
	</div>
		<!--	akhir show	-->
	
