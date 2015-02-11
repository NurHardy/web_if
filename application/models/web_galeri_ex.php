<?php
class web_galeri_ex extends CI_Model {
	/* ============= ALBUM CATEGORY ====================== */
	function save_album_category($categoryName, $idCategory = -1) {
		$result = null;
		if ($idCategory > 0) {
			$this->db->where('f_id', $idCategory);
			$result = $this->db->update('t_category_album', array('f_name'=>$categoryName));
		} else {
			$result = $this->db->insert('t_category_album', array('f_name'=>$categoryName));
		}
		return $result;
	}
	
	/* ============= ALBUM =============================== */
	function save_album($albumData, $idCreator, $creator, $idAlbum = -1) {
		$_query_data = array(
			'nama_album'		=> $albumData[0],
			'id_category'		=> $albumData[1],
			'album_desc'		=> $albumData[2],
			'status'			=> $albumData[3]
		);
		$result = null;
		if ($idAlbum > 0) {
			$this->db->where('id_album', $idAlbum);
			$result = $this->db->update('t_album', $_query_data);
		} else {
			$_query_data['created']		= date('Y-m-d H:i:s');
			$_query_data['id_creator']	= $idCreator;
			$_query_data['creator']		= $creator;
			$result = $this->db->insert('t_album', $_query_data);
		}
		return $result;
	}
	function set_album_status($idAlbum, $newStatus) {
		$this->db->where('id_album', $idAlbum);
		$result = $this->db->update('t_album', array('status'=>$newStatus));
		return $result;
	}
	/* ============= PHOTO =============================== */
	function save_photo($fData, $idCreator, $creator, $idPhoto = -1) {
		$_query_data = array(
			'id_album'			=> $fData[0],
			'filename'			=> $fData[1],
			'file_format'		=> $fData[2],
			'deskripsi_foto'	=> $fData[3],
			'url_foto'			=> $fData[4],
			'url_thumbnail'		=> $fData[5],
			'metadata'			=> $fData[6]
		);
		$result = null;
		if ($idPhoto > 0) {
			$this->db->where('id_foto', $idPhoto);
			$result = $this->db->update('t_galeri', $_query_data);
		} else {
			$_query_data['date_uploaded']	= date('Y-m-d H:i:s');
			$_query_data['id_creator']		= $idCreator;
			$_query_data['creator']			= $creator;
			$result = $this->db->insert('t_galeri', $_query_data);
		}
		return $result;
	}
}
