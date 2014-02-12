<div id='site_content_article'>
	<h2><?php echo $page_title ?></h2>
	<table cellpadding="5px" >
	<?php 
		$bg='#ADD7F7';$bg1='#F1F6FA';$i=1;
		foreach($daftar_event as $_daftar_event) {
		if($i%2==1){
		echo"<tr valign='top' bgcolor=' ".$bg."'>";?>
			<td height="100px" width="650px">
				<h4><?php echo $_daftar_event->f_name; ?><br></h4>
				<h6><?php echo date('j F Y',strtotime($_daftar_event->f_date) );?><br></h6>
				<?php echo $_daftar_event->f_desc; ?><br>
			</td>
		</tr>
		<?php } if ($i%2==0){
		echo"<tr valign='top' bgcolor=' ".$bg1."'>";?>
			<td height="100px" width="450px">
				<h4><?php echo $_daftar_event->f_name; ?><br></h4>
				<h6><?php echo date('j F Y, H:i',strtotime($_daftar_event->f_date) );?><br></h6>
				<?php echo $_daftar_event->f_desc; ?><br>
			</td>
		</tr><?php } 
		$i= $i + 1;?>
	<?php } ?>
	</table>
</div>
