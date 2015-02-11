<div id='site_content_article'>
	<h2><?php echo $page_title?></h2>
	<hr></hr>
	<div id='detail_staff'>
			<table cellpadding='2px'>
				<tr><td align='center' valign='top' width='150px' colspan='3'><?php echo "<img class='foto_staff' src='".base_url($_staff_detail->link_foto)."'/>";?></td></tr>
				<tr align='left'><td width='200px' colspan='3'><h3><?php echo $_staff_detail->nama?></h3></td></tr>
				<tr align='left'><td width='60px'>NIP</td><td>:</td><td width='290px'> <?php echo $_staff_detail->nip?></td></tr>
				<tr align='left'><td>TTL</td><td>:</td><td> <?php echo $_staff_detail->ttl?></td></tr>
				<tr align='left' valign='top'><td>Alamat</td><td>:</td><td> <?php echo $_staff_detail->alamat?></td></tr>
				<tr align='left'><td>NIDN</td><td>:</td><td> <?php echo $_staff_detail->nidn?></td></tr>
				<tr align='left' valign='top'><td>Ijazah</td><td>:</td><td> <?php echo $_staff_detail->pddk?></td></tr>
				<tr align='left' valign='top'><td>Keahlian</td><td>:</td><td> <?php echo $_staff_detail->bidangilmu?></td></tr>
				<tr align='left'><td>Laboratorium</td><td>:</td><td> <?php echo $_staff_detail->lab?></td></tr>
				<tr align='left' valign='top'><td>Mata Kuliah</td><td>:</td><td> <?php echo $_staff_detail->matkul?></td></tr>
				<tr align='left' valign='top'><td>Email</td><td>:</td><td> <?php echo $_staff_detail->email?></td></tr>
				<tr align='left' valign='top'><td>Website</td><td>:</td><td> <?php echo $_staff_detail->website?></td></tr>
			</table>
		</div>
	<div id='list_staff'>
		<table cellpadding='5px'>
		<tr class='tb_head'><td width='20px'>No</td><td width='200px'>Nama</td>
		<?php 
		$i=1;
		foreach($_staff as $staff_) {
		if($i%2==1) echo "<tr class='tb_row_1'>";
		else echo "<tr class='tb_row_2'>";?>
				<td>
					<?php echo $i;?>
				</td>
				<td>
					<?php echo "<a href='".base_url("/staff/{$staff_->nip}")."'>";?><?php echo $staff_->nama?></a>
				</td>
			</tr>
			<?php $i= $i + 1;}?>
		</table>
		</div> 
</div>