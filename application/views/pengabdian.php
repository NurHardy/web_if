<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<hr></hr>
		<select class='tingkatan_mhs'>
			<option value='#'>- pilih tahun -</option>
			<option value='<?php echo base_url('/pengabdian/2013')?>'>&nbsp;&nbsp2013</option>
			<option value='<?php echo base_url('/pengabdian/2012')?>'>&nbsp;&nbsp2012</option>
			<option value='<?php echo base_url('/pengabdian/2011')?>'>&nbsp;&nbsp2011</option>
			<option value='<?php echo base_url('/pengabdian/2010')?>'>&nbsp;&nbsp2010</option>
			<option value='<?php echo base_url('/pengabdian/2009')?>'>&nbsp;&nbsp2009</option>
		</select>
		<?php if ($table!='No'){ ?>
		<table cellpadding='2px'>
		<tr align='center'class='tb_head'><td width='40px'>No</td><td width='400px'>Judul</td><td width='150px'>Sumber Dana</td><td width='150px'>Jumlah Dana</td><td width='70px'>Tahun</td></tr>
		<?php 
		$i=$count_stat;
		foreach($data_pengabdian_ as $_data_pengabdian) {
		if($i%2==1) echo "<tr class='tb_row_1'>";
		else echo "<tr class='tb_row_2'>";?>
				<td align='center'>
					<?php echo $i;?>
				</td>
				<td align='left' >
					<?php echo $_data_pengabdian->judul_kegiatan?>
				</td >
				<td align='center'>
					<?php echo $_data_pengabdian->sumber_dana?>
				</td>
				<td align='center'>
						<?php echo $_data_pengabdian->jumlah_dana?>
				</td>
				<td align='center'>
						<?php echo $_data_pengabdian->tahun?>
				</td>
			</tr>
			<?php $i= $i + 1;}?>
		</table>
		<?php } 
		else $data_pengabdian_;?>
		<div id="divclear"></div>
		<div class='site_list_nav'>
			<?php if (isset($_paging)) echo $_paging; ?>
		</div>
	</div>
	