<?php
class web_mahasiswa extends CI_Model {
/* ------------------------------------------ STAFF ------------------- */	
	function get_mhs_id($nim) 
	{			
		$_query  = "SELECT * FROM t_mahasiswa WHERE nim='$nim'";
		$query = $this->db->query($_query);
        return $query->row();
	}	
	function count_mhs($_tingkatan= -1) {
		$_query  = "SELECT COUNT(*) AS _count FROM t_mahasiswa";
		if ($_tingkatan >= 0) $_query .= " WHERE tingkatan = $_tingkatan";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
	function get_mahasiswa($_items = 15, $_page = 1, $_tingkatan = -1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_mahasiswa";
		if ($_tingkatan >= 0) $_query .= " WHERE  tingkatan = $_tingkatan";
		$_query .= " LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
}