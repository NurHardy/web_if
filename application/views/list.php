
			<div id='site_content_article'>
				<h1>Daftar Posting</h1>
				<table border="1">
					<thead>
					<tr>
						<th>ID</th>
						<th>Judul</th>
						<th>Tanggal</th>
						<th>Creator</th>
					</tr>
				</thead>
				<tbody>
						<?php
							foreach($daftar_post as $posting){
					?>
							<tr>
						<td><?php echo $posting->id_berita; ?></td>
						<td><?php echo $posting->judul; ?></td>
						<td><?php echo $posting->tanggal; ?></td>
						<td><?php echo $posting->creator; ?></td>
					</tr>
					   <?php } ?>
				</tbody>
				</table>
			</div>
