<?php
class web_matkul extends CI_Model {
/* ------------------------------------------ MATA KULIAH ------------------- */
	function get_matkul_smt($semester = -1) {
		$_query  = "SELECT * FROM t_matkul";
		if ($semester > 0) $_query .= " WHERE semester=$semester";
		$query = $this->db->query($_query);
        return $query->result();
	}
	function get_matkul($_kode) {
		$__kode = $this->db->escape_str($_kode);
		$_query  = "SELECT * FROM t_matkul WHERE kodekul='$__kode'";
		$query = $this->db->query($_query);
        return $query->row();
	}
}
