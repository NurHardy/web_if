<link rel="stylesheet" type="text/css" href="<?php echo base_url('/assets/css/jquery.lightbox-0.5.css')?>" media="screen" />
<script type="text/javascript" src="<?php echo base_url('/assets/js/jquery.lightbox-0.5.min.js')?>"></script>
<script type="text/javascript">
	$(function() {
		$('#gallery a').lightBox({
			imageLoading:"<?php echo base_url('/assets/images/lightbox-ico-loading.gif'); ?>",
			imageBtnPrev:"<?php echo base_url('/assets/images/lightbox-btn-prev.gif'); ?>",
			imageBtnNext:"<?php echo base_url('/assets/images/lightbox-btn-next.gif'); ?>",
			imageBtnClose:"<?php echo base_url('/assets/images/lightbox-btn-close.gif'); ?>",
			imageBlank:"<?php echo base_url('/assets/images/lightbox-blank.gif'); ?>"
		});
	});
	</script>
<div id='site_content_article'>
	<h2><?php echo $page_title?></h2>
		<?php
		if($album == 'yes'){?>
		<?php 
		foreach ($daftar_album as $_daftar_album){?>
			<div style="float:left; padding:10px; text-align:center; max-width:200px; border:1px solid #cccccc; padding:5px; margin: 10px">
					<a class="foto_album" href="/v1/galeri/<?php echo $_daftar_album->nama_album?>" title="<?php echo $_daftar_album->nama_album?>">
						<img src ="<?php echo base_url($_daftar_album->url_thumbnail)?>" width="190" style="border: 5px white; max-width:100px; max-height:100px"></a><br><a href="/v1/galeri/<?php echo $_daftar_album->nama_album?>"><?php echo $_daftar_album->nama_album?></a><br>
			</div>
		<?php }  ?>
		<?php }
		else if ($album == 'no') {?>
		<div id="gallery">
			<ul>
			<?php	foreach ($daftar_foto as $_daftar_foto){?>
				<li  style="float:left; text-align:center; max-width:200px;border:1px solid #cccccc; padding:5px; margin: 3px; width:100px; height:100px; index-z:5">
					<a href="<?php echo base_url($_daftar_foto->url_foto)?>" title="<?php echo $_daftar_foto->deskripsi_foto?>">
						<img class="foto_tampil" src ="<?php echo base_url($_daftar_foto->url_foto)?>" style="border: 5px white; max-height:100px; max-width:120px; width:100%; height:100%"></a>
					</a>
				</li>
			<?php }?>
			</ul>
		</div>
		<div class='divclear'></div>
			<h4>Album Lain</h4>
		<div class='divclear'></div>
		<?php 
			foreach ($daftar_album as $_daftar_album){?>
				<div style="float:left; padding:10px;text-align:center; max-width:200px; border:1px solid #cccccc; padding:5px; margin: 10px">
						<a class="foto_album" href="/v1/galeri/<?php echo $_daftar_album->nama_album; ?>" title="<?php echo $_daftar_album->nama_album; ?>">
							<img src ="<?php echo base_url($_daftar_album->url_thumbnail)?>" width="190" style="border: 5px white; max-width:100px; max-height:100px"></a><br><a href="/v1/galeri/<?php echo $_daftar_album->nama_album; ?>"><?php echo $_daftar_album->nama_album; ?></a><br>
				</div>
		<?php } }?>
</div>