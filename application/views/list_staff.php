<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<table cellpadding='2px'>
		<tr class='tb_head'><td width='20px'>No</td><td width='200px'>Nama</td><td width='250px'>Bidang Ilmu</td><td width='70px'>Data Dosen</td></tr>
		<?php 
		$i=1;
		foreach($_staff as $staff_) {
		if($i%2==1) echo "<tr class='tb_row_1'>";
		else echo "<tr class='tb_row_2'>";?>
				<td>
					<?php echo $i;?>
				</td>
				<td>
					<?php echo $staff_->nama?>
				</td>
				<td>
						<?php echo $staff_->bidangilmu?>
				</td>
				<td>
					<?php echo "<a href='".base_url("/staff/{$staff_->nip}")."'>detail&raquo;</a>"?>
				</td>
			</tr>
			<?php $i= $i + 1;}?>
		</table>
		<div id="divclear"></div>
		<!--<div id="pagging">
			<ul>
				<li><a href='#'>&laquo sebelumnya</a></li>
				<li><a href='#'>1</a></li>
				<li><a href='#'>2</a></li>
				<li><a href='#'>3</a></li>
				<li><a href='#'>4</a></li>
				<li><a href='#'>selanjutnya &raquo </a></li>
			</ul>
		</div> -->
	</div>
	