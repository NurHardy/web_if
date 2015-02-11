	<div id="admin_content_left_in">
	<?php if(empty($form)){?>
		<h2>Tambah Slider</h2>
		<form method='post' action='/admin/slide/newslide'name='myform'>   	
			<label class='label_form_slider'>sumber gambar</label><input class='input_form_slider' type='text' name='url_gambar'>
			<label class='label_form_slider'>Narasi</label><textarea class='textarea_slider' name='narasi'></textarea>
			<label class='label_form_slider'>Efek narasi</label>
								<select class='select_efek_slider' name='efek_narasi'>
											<option>pilihan</option>
											<option>caption elemHover fromLeft</option>
											<option>caption elemHover fromRight</option>
											<option>caption elemHover fromTop</option>
											<option>caption elemHover fromBottom</option>
											<option>caption elemHover fadeIn</option>
								</select>
			<label class='label_form_slider'>Status</label>
								<select class='select_efek_slider' name='status_slider'>
											<option>pilihan</option>
											<option>tampil</option>
											<option>draft</option>
								</select>
			<div class="divclear"></div>
			<input class="tombol_aksi" type='submit' value='simpan'> 
			<input class='tombol_aksi' type=button value=batal onclick=self.history.back()>
		</form>
		<?php } ?>
	<div class='divclear' ></div>
	<?php
					if (!empty($errors)) {
						$info_ = '<div class="errormsgbox"><ol>';
						foreach ($errors as $key => $values) {
							$info_ .= '	<li>'.$values."</li>\n";
						}
						$info_ .= '</ol></div>';
						echo $info_;
					}
					if (!empty($success)) {
						$info_ ='<div class="success"><ol>';
						foreach ($success as $key => $values) {
							$info_ .= '	<li>'.$values."</li>\n";
						}
						$info_ .= '</ol></div>';
						echo $info_;
					} 
	?>
	</div>