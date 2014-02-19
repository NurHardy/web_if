
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
		<div class='site_panel_head'>Partner</div>
		<div class='site_panel_body'>
			<div id='partner_mini'>
				<img src='/assets/images/oracle.png' class='site_partner' alt='Oracle Academy'/>
				<img src='/assets/images/msdnaa.png' class='site_partner' alt='MSDN Academic Alliance'/>
			</div>
			<div id="divTrigger">
				 <a href="javascript:;" onClick="openContent(this,'div1')" id="firstSlide">1</a>
				 <a href="javascript:;" onClick="openContent(this,'div2')">2</a>
			</div>
				 
			<div id="divContent">
				<div id="div1">
					<img src='/assets/images/oracle.png' class='site_partner' alt='Oracle Academy'/>
				</div>
				<div id="div2">
					<img src='/assets/images/msdnaa.png' class='site_partner' alt='MSDN Academic Alliance'/>
				 </div>
			</div>
		</div>
	</div>
			<!--	akhir show	-->
		<div class='site_panel'>
			<div class='site_panel_head'>Widget - [Alpha]</div>
			<div class='site_panel_body'>
				<!-- tanggalan -->
				<iframe id='cv_if2' src='http://cdn.instantcal.com/cvir.html?id=cv_nav1&theme=XBL&ntype=cv_datepicker' allowTransparency='true' scrolling='no' frameborder=0 height=200 width=270></iframe>
			</div>
		</div>
