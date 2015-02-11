<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<hr></hr>
		<select class='tingkatan_mhs'>
			<option value='#'>- pilih tahun -</option>
			<option value='<?php echo base_url('/penelitian/2012')?>'>&nbsp;&nbsp2012</option>
			<option value='<?php echo base_url('/penelitian/2011')?>'>&nbsp;&nbsp2011</option>
			<option value='<?php echo base_url('/penelitian/2010')?>'>&nbsp;&nbsp2010</option>
			<option value='<?php echo base_url('/penelitian/2009')?>'>&nbsp;&nbsp2009</option>
			<option value='<?php echo base_url('/penelitian/2008')?>'>&nbsp;&nbsp2008</option>
		</select>
		<?php if ($table!='No'){ ?>
		<table cellpadding='2px'>
		<tr align='center'class='tb_head'><td width='40px'>No</td><td width='350px'>Judul</td><td width='250px'>Peneliti</td><td width='60px'>Tahun</td><td width='100px'>Tingkat</td></tr>
		<?php 
		$i=$count_stat;
		foreach($data_penelitian_ as $_data_penelitian) {
		if($i%2==1) echo "<tr class='tb_row_1'>";
		else echo "<tr class='tb_row_2'>";?>
				<td align='center'>
					<?php echo $i;?>
				</td>
				<td align='left' >
					<?php echo $_data_penelitian->judul?>
				</td >
				<td align='center'>
					<?php echo $_data_penelitian->peneliti?>
				</td>
				<td align='center'>
						<?php echo $_data_penelitian->tahun?>
				</td>
				<td align='center'>
						<?php echo $_data_penelitian->tingkat?>
				</td>
			</tr>
			<?php $i= $i + 1;}?>
		</table>
		<?php } 
		else $data_penelitian_;?>
		<div id="divclear"></div>
		<div class='site_list_nav'>
			<?php if (isset($_paging)) echo $_paging; ?>
		</div>
	</div>
	