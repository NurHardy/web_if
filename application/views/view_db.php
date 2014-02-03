
	<div id='site_content_slider'>
		SLIDER HERE
	</div>
	<div id='site_content_article'>
		<h1>Daftar User</h1>
		<table border="1">
			<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<th>Nama Lengkap</th>
				<th>E-mail</th>
			</tr>
		</thead>
		<tbody>
				<?php
					foreach($daftar_user as $user){
			?>
					<tr>
				<td><?php echo $user->id_; ?></td>
				<td><?php echo $user->id_user; ?></td>
				<td><?php echo $user->nama_lengkap; ?></td>
				<td><?php echo $user->email; ?></td>
			</tr>
			   <?php } ?>
		</tbody>
		</table>
	</div>
	<div id='site_content_more'>
		<ul>
			<li>Artikel 1</li>
			<li>Artikel 2</li>
			<?php if (isset($_GET['p']))echo $_GET['p']; ?>
		</ul>
	</div>
