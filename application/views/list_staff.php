<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<table cellpadding='5px'>
		<tr class='tb_head'><td width='20px'>No</td><td width='150px'>Nama</td><td width='250px'>Mata Kuliah</td><td width='100px'>Data Dosen</td></tr>
		<?php 
		$i=1;
		foreach($_staff as $staff_) {
		if($i%2==1){
		echo"<tr class='tb_row_1'>";?>
				<td>
					<?php echo $staff_->id_staff?>
				</td>
				<td>
					<?php echo $staff_->nama?>
				</td>
				<td>
					<?php echo $staff_->matkul?>
				</td>
				<td>
					<?php echo "<a href='/staff/{$staff_->nip}'>detail&raquo</a>"?>
				</td>
			</tr>
			<?php } if ($i%2==0){
			echo"<tr class='tb_row_2'>";?>
					<td>
					<?php echo $staff_->id_staff?>
					</td>
					<td>
						<?php echo $staff_->nama?>
					</td>
					<td>
						<?php echo $staff_->matkul?>
					</td>
					<td>
						<?php echo "<a href='/staff/{$staff_->nip}'>detail&raquo</a>"?>
					</td>
				</tr><?php } 
			$i= $i + 1;?>
			<?php } ?>
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
	