<script>
function categoryChanged() {
	var provId = $("#site_cat_id").val();
	if (provId == 999) {
		$("#site_newcat_name").show();
	} else {
		$("#site_newcat_name").hide();
	}
}
function album_form_submit() {
	if (is_processing) return false;
	processed_id = -1;
	var formdata = $("#site_form_album").serialize();
	
	_ajax_send("<?php echo base_url('/admin/media/ajax'); ?>", formdata, 'Menyimpan...', function() {
		refreshPage("Me-reload halaman...");
	}, true);
	return false;
}
</script>
<form action="#" method="POST" onsubmit="return album_form_submit();" id="site_form_album">
	<table class="site_table_form">
		<tr>
			<td><label for="site_txt_title">Nama Album:</label></td>
			<td><input type="text" name="site_txt_title" id="site_txt_title" placeholder="Nama Album" value="<?php
				if (isset($site_txt_title)) echo htmlspecialchars($site_txt_title);
				?>" maxlength="64" required/></td>
		</tr>
		<tr>
			<td><label for="site_cat_id">Kategori Album:</label></td>
			<td><select name="site_cat_id" id="site_cat_id" onchange="categoryChanged();">
				<?php
				$selectedCategory = (isset($site_cat_id)?$site_cat_id:0);
				foreach ($listCategory as $itemId => $itemCategory) {
					echo "<option value=\"".$itemId."\" ".($itemId==$selectedCategory?"selected":"").">".
							htmlspecialchars($itemCategory)."</option>";
				}
				?>
				<option value="999">Buat Kategori Album Baru:</option>
			</select><br>
			<input type="text" name="site_newcat_name" id="site_newcat_name" value=""
					placeholder="Kategori Album" style="display:none;" maxlength="64"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="site_published" id="site_published" value="1" <?php
				if (isset($site_published))
					if ($site_published==1)
						echo "checked";
			?> /><label for="site_published"> Publikasikan Album</label></td>
		</tr>
		<tr>
			<td><label for="site_txt_desc">Deskripsi Album:</label></td>
			<td><textarea name="site_txt_desc" id="site_txt_desc" placeholder="Deskripsi Album"><?php
				if (isset($site_txt_desc)) echo htmlspecialchars($site_txt_desc);
			?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><button type="submit"><i class="site_icon-floppy"></i> Submit</button></td>
		</tr>
	</table>
	<input type="hidden" name="id" value="<?php echo (isset($site_item_id)?$site_item_id:-1); ?>" />
	<input type="hidden" name="act" value="<?php echo (isset($site_form_act)?$site_form_act:""); ?>" />
</form>