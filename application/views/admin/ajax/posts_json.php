<?php
	$_mctr = 1;
	$outputArray = array();
	foreach($_posts as $postItem) {
		$postCatLabel = (array_key_exists($postItem->id_kategori, $_cats)?$_cats[$postItem->id_kategori]:"Unknown");
		
		$titleCell	 = "<a href='".base_url("/admin/posts/editpost/{$postItem->id_berita}")."'>";
		$titleCell	.= "<span class='p_title'>{$postItem->judul}</span></a><br>\n";
		$titleCell	.= "<small>oleh : <strong>{$postItem->creator}</strong> | kategori : <strong>{$postCatLabel}</strong></small>";
		
		$actionCell  = "<a href='{$editURLPrefix}/{$postItem->id_berita}' class='adm_row_btn c_col_grey c_img_edit'>Edit</a>\n";
		if ($postItem->status == 1) {
			$actionCell .= "<a href='#' onclick='return unpub(this, {$postItem->id_berita});' class='adm_row_btn c_col_red c_img_pub'>Unpublish</a>\n";
		} else {
			$actionCell .= "<a href='#' onclick='return post_pub(this, {$postItem->id_berita});' class='adm_row_btn c_col_green c_img_pub'>Publish</a>\n";
		}
		$actionCell .= "<a href='#' onclick='return delpost(this, {$postItem->id_berita});' class='adm_row_btn c_col_red c_img_del'>Hapus</a>";
		array_push($outputArray, array(
			'f_title'	=> array(
				'title_val'		=> htmlentities($postItem->judul),
				'title_cell'	=> $titleCell
			),
			'f_hits'	=> $postItem->counter,
			'f_created'	=> array(
				'created_val'	=> strtotime($postItem->tanggal),
				'created_cell'	=> $postItem->tanggal
			),
			'f_acts'	=>	$actionCell
		));
	}
	echo json_encode($outputArray);
