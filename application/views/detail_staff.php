<div id='site_content_article'>
	<h2><?php echo $page_title?></h2>
	<hr></hr>
	<table cellpadding='5px'style='border:solid #797C7F 2px'>
		<tr><td align='center'valign='midle' width='200px' rowspan='8'><?php echo "<img class='foto_staff'src='..".$_staff_detail->link_foto."'/>";?></td>
		<td width='80px' colspan='2'><h3><?php echo $_staff_detail->nama?></h3></td></tr>
		<tr><td width='60px'>NIP</td><td>:&nbsp<?php echo $_staff_detail->nip?></td></tr>
		<tr><td>TTL</td><td>:&nbsp<?php echo $_staff_detail->ttl?></td></tr>
		<tr><td>Alamat</td><td>:&nbsp<?php echo $_staff_detail->alamat?></td></tr>
		<tr><td>NIDN</td><td>:&nbsp<?php echo $_staff_detail->nidn?></td></tr>
		<tr><td>Ijazah</td><td>:&nbsp<?php echo $_staff_detail->pddk?></td></tr>
		<tr><td>Email</td><td>:&nbsp<?php echo $_staff_detail->email?></td></tr>
		<tr><td>HP</td><td>:&nbsp<?php echo $_staff_detail->hp?></td></tr>
	</table>
	<a href='/staff'>&laquokembali</a>
</div>