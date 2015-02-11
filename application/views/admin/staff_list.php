<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<div class='unit'>
			<a href='<?php echo base_url('/admin/staff/newstaff'); ?>' class='button_admin btn_add'>Tambah Baru</a>
		</div>
		<div id="divclear"></div>
		<table cellpadding='2px' style='margin-top:10px'>
		<tr class='tb_head'><td width='25px' align='center'>No</td><td width='200px'>Nama</td><td width='150px' align='center'>Action</td></tr>
		<?php 
		$i=1;
		foreach($list_staff as $staff_) {
		if($i%2==1) echo "<tr class='tb_row_1'>";
		else echo "<tr class='tb_row_2'>";?>
				<td align='center'>
					<?php echo $i;?>
				</td>
				<td>
					<?php echo $staff_->nama?>
				</td>
				<td align='center'>
					<?php echo "<a href='".base_url("/admin/staff/editstaff/{$staff_->nip}")."'>edit</a>"?>
				</td>
			</tr>
			<?php $i= $i + 1;}?>
		</table>
		<div id="divclear"></div>
	</div>
	