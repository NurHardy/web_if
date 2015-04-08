<?php
class web_galeri extends CI_Model {
/* ------------------------------------------ ALBUM ------------------- */
	function get_album($statusFilter = 1) 
	{
		if ($statusFilter > 0)
			$this->db->where('status', $statusFilter);
		$this->db->order_by('id_category','order');
		$query = $this->db->get('t_album');
        return $query->result();
	}
	function get_album_data($idAlbum) {
		$query = $this->db->get_where('t_album', array('id_album'=>$idAlbum), 1);
        return $query->row();
	}
	function get_photo($idPhoto) {
		if (is_array($idPhoto)) {
			$this->db->where_in('id_foto', $idPhoto);
			$query = $this->db->get('t_galeri');
			return $query->result();
		} else {
			$query = $this->db->get_where('t_galeri', array('id_foto'=>$idPhoto), 1);
			return $query->row();
		}
	}
	function get_album_photos($idAlbum, $statusFilter = 1) 
	{
		if ($statusFilter > 0)
			$this->db->where('status', $statusFilter);
		$this->db->where('id_album', $idAlbum);
		$this->db->order_by('order');
		$query = $this->db->get('t_galeri');
        return $query->result();
	}
	function get_foto_album($album) 
	{			
		$_query  = "SELECT * FROM t_galeri WHERE nama_album='$album'";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function get_array_album_categories() {
		$_query  = "SELECT * FROM t_category_album ORDER BY f_id DESC";
		
		$query = $this->db->query($_query);
        $catList = $query->result();
		
		$catArray = array();
		foreach($catList as $catItem) {
			$catArray[$catItem->f_id] = $catItem->f_name;
		}
		$catArray[0] = "Uncategorized";
		ksort($catArray);
		return $catArray;
	}
}
