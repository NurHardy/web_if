<div style="width: 600px; margin: 0 auto;">
	<div style="width: 200px;float: left;">
		<div style="width: 180px; height: 180px; margin: 10px; overflow: hidden; text-align: center;">
			<img src="<?php echo base_url($photoData->url_thumbnail); ?>" alt="Foto" style="height: 100%;"/><br>
		</div>
		<div style="text-align: center; margin: 0 10px;">
			<a href="<?php echo base_url($photoData->url_foto); ?>" target="_blank">
				<i class="site_icon-search"></i> Lihat Versi Asli
			</a>
		</div>
	</div>
	<div style="width: 380px;float: right; padding: 10px;">
		<b>Nama File</b>: <?php echo htmlspecialchars($photoData->filename); ?><br>
		<textarea style="width: 100%;">
		</textarea>
		<div id="photo_metadata">
			<?php echo htmlspecialchars($photoData->metadata); ?>
		</div>
	</div>
	<div class="divclear"></div>
</div>