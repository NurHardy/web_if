<?php
class web_pengabdian extends CI_Model {
/* ------------------------------------------ penelitian ------------------- */	
	function count_pengabdian($_tahun= -1) {
		$_query  = "SELECT COUNT(*) AS _count FROM t_pengabdian";
		if ($_tahun >= 0) $_query .= " WHERE tahun = $_tahun";
		$query = $this->db->query($_query);
		$_res  = $query->row();
        return $_res->_count;
	}
	function get_pengabdian($_items = 15, $_page = 1, $_tahun = -1) {
		$_start = ($_page-1)*$_items;
		$_query  = "SELECT * FROM t_pengabdian";
		if ($_tahun >= 0) $_query .= " WHERE  tahun = $_tahun";
		$_query .= " LIMIT $_start, $_items";
		$query = $this->db->query($_query);
        return $query->result();
	}
}