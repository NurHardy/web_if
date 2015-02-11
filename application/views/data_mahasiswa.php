<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<hr></hr>
		<select class='tingkatan_mhs'>
			<option value='#'>- pilih tingkatan -</option>
			<option value='<?php echo base_url('/data_mahasiswa/2013')?>'>&nbsp;&nbsp2013</option>
			<option value='<?php echo base_url('/data_mahasiswa/2012')?>'>&nbsp;&nbsp2012</option>
			<option value='<?php echo base_url('/data_mahasiswa/2011')?>'>&nbsp;&nbsp2011</option>
			<option value='<?php echo base_url('/data_mahasiswa/2010')?>'>&nbsp;&nbsp2010</option>
			<option value='<?php echo base_url('/data_mahasiswa/2009')?>'>&nbsp;&nbsp2009</option>
		</select>
		<?php if ($table!='No'){ ?>
		<table cellpadding='2px'>
		<tr align='center'class='tb_head'><td width='40px'>No</td><td width='250px'>Nama</td><td width='160px'>NIM</td><td class='hidden_on_mobile' width='150px'>Tingkatan</td><td width='340px'>Alamat</td></tr>
		<?php 
		$i=$count_stat;
		foreach($data_mhs as $_data_mhs) {
		if($i%2==1) echo "<tr class='tb_row_1'>";
		else echo "<tr class='tb_row_2'>";?>
				<td align='center'>
					<?php echo $i;?>
				</td>
				<td align='left' >
					<?php echo $_data_mhs->nama?>
				</td >
				<td align='center'>
					<?php echo $_data_mhs->nim?>
				</td>
				<td class='hidden_on_mobile' align='center'>
						<?php echo $_data_mhs->tingkatan?>
				</td>
				<td align='left'>
						<?php echo $_data_mhs->alamat_asal?>
				</td>
			</tr>
			<?php $i= $i + 1;}?>
		</table>
		<?php } 
		else $data_mhs;?>
		
		<div id="divclear"></div>
		<div class='site_list_nav'>
			<?php if (isset($_paging)) echo $_paging; ?>
		</div>
	</div>
	