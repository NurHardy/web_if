<div id='site_content_article'>
		<h2><?php echo $page_title?></h2>
		<table cellpadding='5px'>
		<?php 
		$bg='#ADD7F7';$bg1='#F1F6FA';$i=1;
		foreach($_staff as $staff_) {
		if($i%2==1){
		echo"<tr valign='top' style='border-top:#004A87 solid 1px' bgcolor=' ".$bg."'>";?>
				<td style='min-width:40px;max-width:100px;width:10%'>
					<img class="photo_staff" src='/assets/images/test_banner_2.jpg'/>
				</td>
				<td style='min-width:40px;max-width:100px;width:20%'>
					Nama <br>
					TTL  <br>
					Alamat<br>
					Ijazah<br>
					NIP		<br>
					NIDN	<br>
					HP		<br>
					Email	<br>
				</td>
				<td style='max-width:400px;width:50%' >
					:&nbsp&nbsp<?php echo $staff_->nama;?><br>
					:&nbsp&nbsp<?php echo $staff_->ttl;?><br>
					:&nbsp&nbsp<?php echo $staff_->alamat;?><br>
					:&nbsp&nbsp<?php echo $staff_->pddk;?><br>
					:&nbsp&nbsp<?php echo $staff_->nip;?><br>
					:&nbsp&nbsp<?php echo $staff_->nidn;?><br>
					:&nbsp&nbsp<?php echo $staff_->hp;?><br>
					:&nbsp&nbsp<?php echo $staff_->email;?><br>
				</td>
			</tr>
			<?php } if ($i%2==0){
			echo"<tr valign='top' style='border-top:#004A87 solid 1px' bgcolor=' ".$bg1."'>";?>
				<td width='100px'>
						<img class="photo_staff" src='/assets/images/test_banner_2.jpg'/>
					</td>
					<td width='100px'>
						Nama <br>
						TTL  <br>
						Alamat<br>
						Ijazah<br>
						NIP		<br>
						NIDN	<br>
						HP		<br>
						Email	<br>
					</td>
					<td width='350px' >
						:&nbsp&nbsp<?php echo $staff_->nama;?><br>
						:&nbsp&nbsp<?php echo $staff_->ttl;?><br>
						:&nbsp&nbsp<?php echo $staff_->alamat;?><br>
						:&nbsp&nbsp<?php echo $staff_->pddk;?><br>
						:&nbsp&nbsp<?php echo $staff_->nip;?><br>
						:&nbsp&nbsp<?php echo $staff_->nidn;?><br>
						:&nbsp&nbsp<?php echo $staff_->hp;?><br>
						:&nbsp&nbsp<?php echo $staff_->email;?><br>
					</td>
				</tr><?php } 
			$i= $i + 1;?>
			<?php } ?>
			<tr style="border-top:#004A87 solid 1px"></tr>
		</table>
		<div id="divclear"></div>
		<div id="pagging">
			<ul>
				<li><a href='#'>&laquo sebelumnya</a></li>
				<li><a href='#'>1</a></li>
				<li><a href='#'>2</a></li>
				<li><a href='#'>3</a></li>
				<li><a href='#'>4</a></li>
				<li><a href='#'>selanjutnya &raquo </a></li>
			</ul>
		</div>
	</div>
	